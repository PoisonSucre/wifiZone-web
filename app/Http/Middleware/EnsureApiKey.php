<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureApiKey
{
    public function handle(Request $request, Closure $next): Response
    {
        $key = $request->header('X-API-Key');
        $expected = config('platform.api_key');

        if ($expected && is_string($key) && hash_equals($expected, $key)) {
            return $next($request);
        }

        return response()->json(['error' => 'Unauthorized'], 401);
    }
}
