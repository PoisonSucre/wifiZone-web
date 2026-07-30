<?php

use App\Http\Middleware\EnsureAdmin;
use App\Http\Middleware\EnsureVendeurIsActive;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->web(append: [
            \App\Http\Middleware\ApplyThemeMiddleware::class,
        ]);

        $middleware->validateCsrfTokens(except: [
            'payment/init',
        ]);

        $middleware->alias([
            'vendeur.status' => EnsureVendeurIsActive::class,
            'admin' => EnsureAdmin::class,
        ]);

        // $middleware->statefulApi(); // Sanctum non installe

        $middleware->trustProxies(at: [
            '10.0.0.0/8',
            '172.16.0.0/12',
            '192.168.0.0/16',
            '100.64.0.0/10',
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->shouldRenderJsonWhen(
            fn (Request $request) => $request->is('api/*'),
        );
    })->create();
