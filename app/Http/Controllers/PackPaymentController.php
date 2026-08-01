<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Services\HotspotService;
use App\Services\LigdiCashService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class PackPaymentController extends Controller
{
    public function init(Request $request, string $packKey, HotspotService $hotspots, LigdiCashService $ligdiCash): RedirectResponse
    {
        $vendeur = auth()->user();
        $pack = $hotspots->pack($packKey);

        if (!$pack) {
            return redirect()->back()->with('error', 'Pack de hotspot inconnu.');
        }

        $transactionId = $ligdiCash->generateTransactionId();

        $payload = $ligdiCash->buildPayload(
            ['label' => "Pack Hotspots {$pack['key']}", 'montant' => $pack['price']],
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
                'montant' => $pack['price'],
                'statut' => 'pending',
                'type' => 'pack',
                'payment_method' => 'ligdicash',
                'pack_key' => $packKey,
            ]);

            return redirect()->away($data['response_text']);
        }

        return redirect()->back()->with('error', 'Paiement impossible.');
    }
}
