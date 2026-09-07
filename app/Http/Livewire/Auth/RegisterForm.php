<?php

namespace App\Http\Livewire\Auth;

use App\Mail\VendorRegisteredMail;
use App\Models\Vendeur;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;

class RegisterForm extends Component
{
    public int $step = 1;
    public string $nom = '';
    public string $prenom = '';
    public string $email = '';
    public string $telephone = '';
    public string $password = '';
    public string $passwordConfirmation = '';

    public function nextStep(): void
    {
        if ($this->step === 1) {
            $this->validate([
                'nom' => 'required|string|max:100',
                'prenom' => 'required|string|max:100',
            ]);
        } elseif ($this->step === 2) {
            $this->validate([
                'email' => 'required|email|unique:vendeurs,email',
                'telephone' => 'required|string|max:20',
            ]);
        }
        $this->step++;
    }

    public function submit(): void
    {
        if ($this->step === 3) {
            $this->register();
        } else {
            $this->nextStep();
        }
    }

    public function prevStep(): void { $this->step--; }

    public function register(): void
    {
        $this->validate([
            'nom' => 'required|string|max:100',
            'prenom' => 'required|string|max:100',
            'email' => 'required|email|unique:vendeurs,email',
            'telephone' => 'required|string|max:20',
            'password' => 'required|string|min:8|same:passwordConfirmation',
        ]);

        try {
            $vendeur = Vendeur::create([
                'nom' => $this->nom, 'prenom' => $this->prenom,
                'email' => $this->email, 'telephone' => $this->telephone,
                'password' => $this->password, 'statut' => 'en_attente',
                'commission_pct' => config('platform.commission_pct', 10),
                'card_number' => Vendeur::generateCardNumber(),
            ]);
        } catch (\Throwable $e) {
            try { Log::error('Erreur création vendeur', ['message' => $e->getMessage()]); } catch (\Throwable) {}
            $this->dispatch('toast', type: 'error', message: 'Une erreur est survenue lors de l\'inscription. Veuillez réessayer plus tard.');
            return;
        }

        // Envoi des emails — ne doit jamais bloquer l'inscription
        try {
            Mail::to($vendeur->email)->send(new VendorRegisteredMail($vendeur));
        } catch (\Throwable $e) {
            try { Log::error('Erreur notification vendeur', ['to' => $vendeur->email, 'error' => $e->getMessage()]); } catch (\Throwable) {}
        }

        session(['pending_vendor_email' => $this->email]);

        try {
            $verificationUrl = \Illuminate\Support\Facades\URL::temporarySignedRoute(
                'vendor.verify',
                now()->addMinutes(30),
                ['id' => $vendeur->id, 'hash' => hash('sha256', $vendeur->email)]
            );
            \Illuminate\Support\Facades\Mail::to($vendeur->email)->send(
                new \App\Mail\EmailVerificationMail($vendeur, $verificationUrl)
            );
        } catch (\Throwable $e) {
            try { Log::error('Erreur envoi email vérification', ['to' => $vendeur->email, 'error' => $e->getMessage()]); } catch (\Throwable) {}
        }

        $this->redirectRoute('vendor.verify-email');
    }

    public function render() { return view('livewire.auth.register-form'); }
}
