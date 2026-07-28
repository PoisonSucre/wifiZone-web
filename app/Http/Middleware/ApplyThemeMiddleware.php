<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ApplyThemeMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $theme = $request->cookies->get('theme');
        view()->share('themeClass', $theme === 'dark' ? 'dark' : '');

        return $next($request);
    }
}
