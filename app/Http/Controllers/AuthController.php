<?php

namespace App\Http\Controllers;

use App\Mail\VendorRegisteredMail;
use App\Models\Setting;
use App\Models\Vendeur;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class AuthController extends Controller
{
    public function showLogin()
    {
        if (Auth::check()) {
            return redirect()->route('vendor.dashboard');
        }

        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $vendeur = Vendeur::where('email', $request->email)->first();

        if (!$vendeur || !Hash::check($request->password, $vendeur->password)) {
            return back()->withErrors(['email' => 'Identifiants incorrects.'])->withInput($request->only('email'));
        }

        if ($vendeur->statut === 'en_attente') {
            return redirect()->route('vendor.pending');
        }

        if ($vendeur->statut === 'suspendu') {
            return redirect()->route('vendor.suspended');
        }

        if (!$vendeur->email_verified_at) {
            session(['pending_vendor_email' => $vendeur->email]);
            return redirect()->route('vendor.verify-email');
        }

        Auth::login($vendeur);
        $vendeur->update(['last_login' => now()]);

        $request->session()->regenerate();

        return redirect()->intended(route('vendor.dashboard'));
    }

    public function showRegister()
    {
        if (Auth::check()) {
            return redirect()->route('vendor.dashboard');
        }

        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:100',
            'prenom' => 'required|string|max:100',
            'email' => 'required|email|unique:vendeurs,email',
            'telephone' => 'required|string|max:20',
            'adresse' => 'nullable|string|max:255',
            'ville' => 'nullable|string|max:100',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $vendeur = Vendeur::create([
            'nom' => $request->nom,
            'prenom' => $request->prenom,
            'email' => $request->email,
            'telephone' => $request->telephone,
            'adresse' => $request->adresse,
            'ville' => $request->ville,
            'password' => $request->password,
            'statut' => 'en_attente',
            'commission_pct' => config('platform.commission_pct', 10),
            'card_number' => Vendeur::generateCardNumber(),
        ]);

        try {
            Mail::to($vendeur->email)->send(new VendorRegisteredMail($vendeur));
            Log::info('Notification vendeur envoyée', ['to' => $vendeur->email]);
        } catch (\Exception $e) {
            Log::error('Erreur notification vendeur', ['to' => $vendeur->email, 'error' => $e->getMessage()]);
        }

        $verificationUrl = \Illuminate\Support\Facades\URL::temporarySignedRoute(
            'vendor.verify',
            now()->addMinutes(60),
            ['id' => $vendeur->id, 'hash' => hash('sha256', $vendeur->email)]
        );

        try {
            Mail::to($vendeur->email)->send(new \App\Mail\EmailVerificationMail($vendeur, $verificationUrl));
        } catch (\Exception $e) {
            Log::error('Erreur envoi email vérification', ['to' => $vendeur->email, 'error' => $e->getMessage()]);
        }

        session(['pending_vendor_email' => $vendeur->email]);

        return redirect()->route('vendor.verify-email')
            ->with('status', 'Votre compte a été créé. Veuillez vérifier votre email.');
    }

    public function pending()
    {
        return view('auth.pending');
    }

    public function suspended()
    {
        return view('auth.suspended');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('vendor.login');
    }
}
