<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Mail\HotspotPackConfirmedMail;
use App\Mail\TransactionCompletedMail;
use App\Models\Transaction;
use App\Models\Vendeur;
use App\Services\HotspotService;
use App\Services\LigdiCashService;
use App\Services\TicketService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class PaymentApiController extends Controller
{
    public function __construct(
        private LigdiCashService $ligdiCash,
        private TicketService $tickets,
    ) {}

    public function process(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'vendeur_id' => 'required|exists:vendeurs,id',
            'montant' => 'required|integer|min:9',
            'forfait' => 'required|string',
        ]);

        \Illuminate\Support\Facades\Log::info('Payment process validated', [
            'validated_montant' => $validated['montant'],
            'request_montant' => $request->montant,
        ]);

        $vendeur = Vendeur::active()->findOrFail($request->vendeur_id);

        $query = $vendeur->forfaits()->active()->where('label', $request->forfait);
        $hsId = (int) $request->input('hotspot_id', 0);
        if ($hsId > 0) {
            $query->where('hotspot_id', $hsId);
        }
        $forfait = $query->first();

        if (!$forfait) {
            return response()->json(['error' => 'Forfait non trouvé'], 404);
        }

        $raison = app(HotspotService::class)->saleBlockReason($vendeur, $forfait->hotspot);
        if ($raison) {
            return response()->json([
                'blocked' => true,
                'redirect' => route('portail-indisponible', ['vendeur_id' => $vendeur->id, 'raison' => $raison]),
            ], 403);
        }

        $montant = (int) $validated['montant'];
        $transactionId = $this->ligdiCash->generateTransactionId();

        $payload = $this->ligdiCash->buildPayload(
            array_merge($forfait->toArray(), ['montant' => $montant]),
            $vendeur->id,
            $transactionId
        );
        $payload['client']['email'] = $vendeur->email;

        $data = $this->ligdiCash->createInvoice($payload);

        if (isset($data['response_code']) && $data['response_code'] === '00') {
            Transaction::create([
                'vendeur_id' => $vendeur->id,
                'token' => $data['token'] ?? null,
                'transaction_id' => $transactionId,
                'montant' => $montant,
                'statut' => 'pending',
            ]);

            return response()->json([
                'success' => true,
                'payment_url' => $data['response_text'] ?? null,
                'invoice_token' => $data['token'] ?? null,
            ]);
        }

        return response()->json(['error' => 'Erreur de création de facture', 'details' => $data], 400);
    }

    public function callback(Request $request): JsonResponse
    {
        // LigdiCash envoie 2 POSTs : application/x-www-form-urlencoded + application/json
        // Si c'est le form-urlencoded, on ne le traite pas (déduplication)
        if (str_contains($request->header('Content-Type', ''), 'application/x-www-form-urlencoded')) {
            return response('OK');
        }

        $payload = $request->json()->all();
        $customData = $payload['custom_data'] ?? [];

        // LigdiCash renvoie custom_data sous forme de tableau d'objets
        // avec keyof_customdata / valueof_customdata
        if (is_array($customData) && isset($customData[0])) {
            $extracted = [];
            foreach ($customData as $entry) {
                if (isset($entry['keyof_customdata'], $entry['valueof_customdata'])) {
                    $extracted[$entry['keyof_customdata']] = $entry['valueof_customdata'];
                }
            }
            $customData = $extracted;
        }

        $transactionId = $customData['transaction_id'] ?? null;
        $vendeurId = $customData['vendeur_id'] ?? null;

        if (!$transactionId) {
            Log::warning('Payment callback missing transaction_id', ['payload' => $payload]);
            return response()->json(['error' => 'Missing transaction_id'], 400);
        }

        $transaction = DB::transaction(function () use ($transactionId) {
            return Transaction::where('transaction_id', $transactionId)->lockForUpdate()->first();
        });

        if (!$transaction) {
            Log::warning('Payment callback transaction not found', ['transaction_id' => $transactionId]);
            return response()->json(['error' => 'Transaction not found'], 404);
        }

        if (in_array($transaction->statut, ['completed', 'notcompleted'])) {
            return response('OK');
        }

        $confirmData = $this->ligdiCash->confirmPayment($transaction->token);
        $status = $confirmData['data']['status'] ?? 'unknown';

        $transaction->update([
            'statut' => $status === 'completed' ? 'completed' : 'notcompleted',
            'phone_number' => $confirmData['data']['phone_number'] ?? null,
            'verification_status' => 'verified',
        ]);

        if ($status === 'completed' && $transaction->type === 'pack') {
            $this->handlePackPurchase($transaction);
            return response('OK');
        }

        if ($status === 'completed') {
            $ticket = $this->tickets->assignTicket($transaction->vendeur_id, $transaction->montant, $transaction->token);

            if ($ticket) {
                $transaction->update(['ticket_id' => $ticket->id]);

                $vendeur = Vendeur::find($transaction->vendeur_id);
                $commissionPct = $vendeur?->commission_pct ?? config('platform.commission_pct', 10);
                $commission = $transaction->montant * ($commissionPct / 100);
                $transaction->update(['commission' => $commission]);

                try {
                    Mail::to($vendeur->email)->send(new TransactionCompletedMail($transaction, $ticket));
                } catch (\Exception $e) {
                    Log::error('Erreur envoi email transaction', ['vendeur_id' => $vendeur->id, 'error' => $e->getMessage()]);
                }
            } else {
                Log::warning('Payment callback: no available ticket', [
                    'transaction_id' => $transactionId,
                    'vendeur_id' => $transaction->vendeur_id,
                    'montant' => $transaction->montant,
                ]);
            }
        }

        return response('OK');
    }

    private function handlePackPurchase(Transaction $transaction): void
    {
        try {
            $vendeur = Vendeur::find($transaction->vendeur_id);
            if (!$vendeur) {
                Log::warning('Pack purchase: vendeur introuvable', ['transaction_id' => $transaction->transaction_id]);
                return;
            }

        $packKey = $transaction->pack_key;

        if (!$packKey || !app(HotspotService::class)->pack($packKey)) {
            Log::warning('Pack purchase: pack_key invalide ou manquant', [
                'transaction_id' => $transaction->transaction_id,
                'pack_key' => $packKey,
            ]);
            return;
        }

         $subscription = app(HotspotService::class)->renewSubscription(
             $vendeur,
             $packKey,
             'ligdicash'
         );

            try {
                Mail::to($vendeur->email)->send(new HotspotPackConfirmedMail($subscription));
            } catch (\Exception $e) {
                Log::error('Erreur envoi email pack', ['vendeur_id' => $vendeur->id, 'error' => $e->getMessage()]);
            }
        } catch (\Exception $e) {
            Log::error('Erreur activation pack', [
                'transaction_id' => $transaction->transaction_id,
                'error' => $e->getMessage(),
            ]);
        }
    }
}
