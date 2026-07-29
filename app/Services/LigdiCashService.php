<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class LigdiCashService
{
    private string $apiKey;
    private string $apiToken;
    private string $baseUrl;

    public function __construct()
    {
        $this->apiKey = config('platform.ligdicash.api_key');
        $this->apiToken = config('platform.ligdicash.api_token');
        $this->baseUrl = config('platform.ligdicash.base_url');
    }

    public function createInvoice(array $data): array
    {
        $response = Http::withHeaders([
            'Apikey' => $this->apiKey,
            'Authorization' => "Bearer {$this->apiToken}",
            'Content-Type' => 'application/json',
        ])->timeout(15)->post("{$this->baseUrl}/create", $data);

        $body = $response->json();

        Log::info('LigdiCash createInvoice', [
            'status' => $response->status(),
            'response_code' => $body['response_code'] ?? null,
        ]);

        return $body;
    }

    public function confirmPayment(string $invoiceToken): array
    {
        $response = Http::withHeaders([
            'Apikey' => $this->apiKey,
            'Authorization' => "Bearer {$this->apiToken}",
        ])->timeout(15)->get("{$this->baseUrl}/confirm", [
            'invoiceToken' => $invoiceToken,
        ]);

        $body = $response->json();

        Log::info('LigdiCash confirmPayment', [
            'token' => $invoiceToken,
            'status' => $response->status(),
        ]);

        return $body;
    }

    public function buildPayload(array $forfait, int $vendeurId, string $transactionId): array
    {
        $baseUrl = config('platform.urls.base');

        $montant = max((int)($forfait['montant'] ?? 0), 9);

        return [
            'commande' => [
                'invoice' => [
                    'items' => [[
                        'name' => "WiFi - {$forfait['label']}",
                        'description' => "Accès WiFi {$forfait['label']}",
                        'quantity' => 1,
                        'unit_price' => $montant,
                        'total_price' => $montant,
                    ]],
                    'total_amount' => $montant,
                    'devise' => config('platform.currency', 'XOF'),
                    'description' => "Accès WiFi {$forfait['label']}",
                    'customer' => '',
                    'customer_firstname' => '',
                    'customer_lastname' => '',
                    'customer_email' => '',
                ],
                'store' => [
                    'name' => config('platform.name', 'Wifi Pour Tous'),
                    'website_url' => config('platform.urls.base', 'http://localhost:8000'),
                ],
                'actions' => [
                    'cancel_url' => "{$baseUrl}/annule?token={token}&vendeur_id={$vendeurId}",
                    'return_url' => "{$baseUrl}/merci?invoiceToken={token}&vendeur_id={$vendeurId}",
                    'callback_url' => "{$baseUrl}/api/payment-callback",
                ],
                'custom_data' => [
                    'transaction_id' => $transactionId,
                    'vendeur_id' => $vendeurId,
                ],
            ],
        ];
    }

    public function generateTransactionId(): string
    {
        return 'WP-' . strtoupper(bin2hex(random_bytes(5)));
    }
}
