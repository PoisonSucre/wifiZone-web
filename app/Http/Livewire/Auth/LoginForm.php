<?php

namespace App\Http\Livewire\Auth;

use App\Models\Vendeur;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginForm extends Component
{
    public string $email = '';
    public string $password = '';

    public function login(): void
    {
        $this->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $vendeur = Vendeur::where('email', $this->email)->first();

        if (!$vendeur || !Hash::check($this->password, $vendeur->password)) {
            $this->dispatch('toast', type: 'error', message: 'Identifiants incorrects.');
            return;
        }

        if ($vendeur->statut === 'en_attente') {
            $this->redirect(route('vendor.pending'));
            return;
        }

        if ($vendeur->statut === 'suspendu') {
            $this->redirect(route('vendor.suspended'));
            return;
        }

        if (!$vendeur->email_verified_at) {
            session(['pending_vendor_email' => $vendeur->email]);
            $this->redirect(route('vendor.verify-email'));
            return;
        }

        Auth::login($vendeur);
        $vendeur->update(['last_login' => now()]);
        session()->regenerate();

        $this->dispatch('toast', type: 'success', message: 'Connexion réussie.');
        $this->redirect(session()->get('url.intended', route('vendor.dashboard')));
    }

    public function render() { return view('livewire.auth.login-form'); }
}
