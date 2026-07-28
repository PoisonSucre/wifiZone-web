<?php

namespace App\Http\Controllers;

use App\Mail\EmailVerificationMail;
use App\Models\Vendeur;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;

class EmailVerificationController extends Controller
{
    public function notice()
    {
        return view('auth.verify-email');
    }

    public function verify(Request $request, string $id, string $hash)
    {
        if (!URL::hasValidSignature($request)) {
            return redirect()->route('vendor.forgot-password')
                ->withErrors(['email' => 'Ce lien de vérification est invalide ou a expiré.']);
        }

        $vendeur = Vendeur::findOrFail($id);

        if ($vendeur->email_verified_at) {
            Auth::login($vendeur);
            return redirect()->route('vendor.dashboard');
        }

        $vendeur->update([
            'email_verified_at' => now(),
            'statut' => 'actif',
        ]);

        Auth::login($vendeur);
        $vendeur->update(['last_login' => now()]);
        session()->regenerate();

        return redirect()->route('vendor.dashboard')
            ->with('success', 'Votre email a été vérifié avec succès. Bienvenue !');
    }

    public function resend(Request $request)
    {
        $email = $request->query('email') ?? session('pending_vendor_email');

        if (!$email) {
            return redirect()->route('vendor.forgot-password');
        }

        $vendeur = Vendeur::where('email', $email)->first();

        if (!$vendeur) {
            return redirect()->route('vendor.forgot-password');
        }

        if ($vendeur->email_verified_at) {
            Auth::login($vendeur);
            return redirect()->route('vendor.dashboard');
        }

        $this->sendVerificationEmail($vendeur);

        return back()->with('success', 'Un nouvel email de vérification a été envoyé.');
    }

    public function sendVerificationEmail(Vendeur $vendeur): void
    {
        $verificationUrl = URL::temporarySignedRoute(
            'vendor.verify',
            now()->addMinutes(60),
            ['id' => $vendeur->id, 'hash' => hash('sha256', $vendeur->email)]
        );

        try {
            Mail::to($vendeur->email)->send(new EmailVerificationMail($vendeur, $verificationUrl));
        } catch (\Exception $e) {
            \Log::error('Erreur envoi email verification', ['email' => $vendeur->email, 'error' => $e->getMessage()]);
        }
    }
}
