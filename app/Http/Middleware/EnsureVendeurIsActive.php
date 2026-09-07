<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureVendeurIsActive
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check()) {
            return redirect()->route('vendor.login');
        }

        $vendeur = Auth::user();

        if ($vendeur->statut === 'en_attente') {
            session(['pending_vendor_email' => $vendeur->email]);
            return redirect()->route('vendor.verify-email')
                ->with('status', 'Veuillez vérifier votre adresse email pour activer votre compte.');
        }

        if ($vendeur->statut === 'suspendu') {
            $email = $vendeur->email;
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            session(['suspended_vendor_email' => $email]);
            return redirect()->route('vendor.suspended');
        }

        return $next($request);
    }
}
