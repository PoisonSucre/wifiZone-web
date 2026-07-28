<?php

use App\Models\Vendeur;

return [

    'defaults' => [
        'guard' => env('AUTH_GUARD', 'web'),
        'passwords' => env('AUTH_PASSWORD_BROKER', 'users'),
    ],

    'guards' => [
        'web' => [
            'driver' => 'session',
            'provider' => 'vendeurs',
        ],
        'admin' => [
            'driver' => 'session',
            'provider' => 'admins',
        ],
    ],

    'providers' => [
        'vendeurs' => [
            'driver' => 'eloquent',
            'model' => Vendeur::class,
        ],
        'admins' => [
            'driver' => 'eloquent',
            'model' => Vendeur::class,
        ],
    ],

    'passwords' => [
        'users' => [
            'provider' => 'vendeurs',
            'table' => 'password_reset_tokens',
            'expire' => 60,
            'throttle' => 60,
        ],
    ],

    'password_timeout' => env('AUTH_PASSWORD_TIMEOUT', 10800),

];
