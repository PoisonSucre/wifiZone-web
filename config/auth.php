<?php

use App\Models\Admin;
use App\Models\Vendeur;

return [

    'defaults' => [
        'guard' => 'vendor',
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
        'vendor' => [
            'driver' => 'session',
            'provider' => 'vendeurs',
        ],
    ],

    'providers' => [
        'vendeurs' => [
            'driver' => 'eloquent',
            'model' => Vendeur::class,
        ],
        'admins' => [
            'driver' => 'eloquent',
            'model' => Admin::class,
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
