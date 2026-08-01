<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Vendeur;
use App\Services\LigdiCashService;
use Illuminate\Http\Request;

class PaymentInitController extends Controller
{
    public function init(Request $request, LigdiCashService $ligdiCash)
    {
        $validated = $request->validate([
            'vendeur_id' => 'required|exists:vendeurs,id',
            'montant' => 'required|integer|min:9',
            'forfait' => 'required|string',
        ]);

        $vendeur = Vendeur::active()->findOrFail($request->vendeur_id);
        $forfait = $vendeur->forfaits()->active()->where('label', $request->forfait)->first();

        if (!$forfait) {
            return redirect()->route('annule', ['error' => 'Forfait non trouvé']);
        }

        $montant = (int) $validated['montant'];
        $transactionId = $ligdiCash->generateTransactionId();

        $payload = $ligdiCash->buildPayload(
            array_merge($forfait->toArray(), ['montant' => $montant]),
            $vendeur->id,
            $transactionId
        );
        $payload['client']['email'] = $vendeur->email;

        $data = $ligdiCash->createInvoice($payload);

        if (isset($data['response_code']) && $data['response_code'] === '00') {
            Transaction::create([
                'vendeur_id' => $vendeur->id,
                'token' => $data['token'] ?? null,
                'transaction_id' => $transactionId,
                'montant' => $montant,
                'statut' => 'pending',
                'type' => 'ticket',
            ]);

            return redirect()->away($data['response_text']);
        }

        return redirect()->route('annule', ['error' => 'Paiement impossible']);
    }
}
