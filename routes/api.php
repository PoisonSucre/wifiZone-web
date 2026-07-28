<?php

use App\Http\Controllers\Api\PaymentApiController;
use Illuminate\Support\Facades\Route;

// --- Payment (Public webhook) ---
Route::post('/payment-process', [PaymentApiController::class, 'process']);
Route::post('/payment-callback', [PaymentApiController::class, 'callback']);
