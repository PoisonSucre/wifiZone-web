<?php

return [
    'name' => env('PLATFORM_NAME', 'Wifi Pour Tous'),
    'currency' => env('PLATFORM_CURRENCY', 'XOF'),
    'commission_pct' => (float) env('PLATFORM_COMMISSION_PCT', 10),
    'support_email' => env('PLATFORM_SUPPORT_EMAIL'),

    'ligdicash' => [
        'api_key' => env('LIGDICASH_API_KEY'),
        'api_token' => env('LIGDICASH_API_TOKEN'),
        'base_url' => env('LIGDICASH_BASE_URL', 'https://app.ligdicash.com/pay/v01/redirect/checkout-invoice'),
    ],

    'api_key' => env('APP_API_KEY'),

    'urls' => [
        'base' => env('BASE_URL', 'http://localhost:8000'),
        'callback' => env('CALLBACK_URL'),
        'return' => env('RETURN_URL'),
        'cancel' => env('CANCEL_URL'),
    ],
];
