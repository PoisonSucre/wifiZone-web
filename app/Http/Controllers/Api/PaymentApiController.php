<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\Vendeur;
use App\Services\LigdiCashService;
use App\Services\TicketService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

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
        $forfait = $vendeur->forfaits()->active()->where('label', $request->forfait)->first();

        if (!$forfait) {
            return response()->json(['error' => 'Forfait non trouvé'], 404);
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
        $payload = $request->json()->all();

        $transactionId = $payload['custom_data']['transaction_id'] ?? null;
        $vendeurId = $payload['custom_data']['vendeur_id'] ?? null;

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

        if ($status === 'completed') {
            $ticket = $this->tickets->assignTicket($transaction->vendeur_id, $transaction->montant, $transaction->token);

            if ($ticket) {
                $transaction->update(['ticket_id' => $ticket->id]);

                $vendeur = Vendeur::find($transaction->vendeur_id);
                $commissionPct = $vendeur?->commission_pct ?? config('platform.commission_pct', 10);
                $commission = $transaction->montant * ($commissionPct / 100);
                $transaction->update(['commission' => $commission]);

                try {
                    $vendeur->notify(new \App\Notifications\TransactionCompletedNotification($transaction, $ticket));
                } catch (\Exception $e) {
                    Log::error('Erreur notification transaction', ['vendeur_id' => $vendeur->id, 'error' => $e->getMessage()]);
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
}
