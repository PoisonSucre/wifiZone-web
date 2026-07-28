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

        return [
            'items' => [[
                'name' => "WiFi - {$forfait['label']}",
                'description' => "Accès WiFi {$forfait['label']}",
                'quantity' => 1,
                'unit_price' => $forfait['montant'],
                'total_price' => $forfait['montant'],
            ]],
            'custom_data' => [
                'transaction_id' => $transactionId,
                'vendeur_id' => $vendeurId,
            ],
            'invoice' => [
                'description' => "Accès WiFi {$forfait['label']}",
            ],
            'callback_url' => "{$baseUrl}/api/payment-callback",
            'return_url' => "{$baseUrl}/merci?invoiceToken={token}&vendeur_id={$vendeurId}",
            'cancel_url' => "{$baseUrl}/annule?token={token}&vendeur_id={$vendeurId}",
            'client' => [
                'email' => '',
            ],
        ];
    }

    public function generateTransactionId(): string
    {
        return 'WP-' . strtoupper(bin2hex(random_bytes(5)));
    }
}
