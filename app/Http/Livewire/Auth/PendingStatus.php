<?php

namespace App\Http\Livewire\Auth;

use App\Models\Vendeur;
use Livewire\Component;

class PendingStatus extends Component
{
    public ?string $status = null;

    public function checkStatus(): void
    {
        $this->pollStatus();
    }

    public function pollStatus(): void
    {
        $email = session('pending_vendor_email');

        if (empty($email)) {
            $this->status = null;
            return;
        }

        $vendeur = Vendeur::where('email', $email)->first();

        if (!$vendeur) {
            $this->status = 'not_found';
            return;
        }

        if ($vendeur->statut === 'actif') {
            $this->status = 'actif';
            $this->dispatch('redirect-to-login');
            return;
        }

        if ($vendeur->statut === 'suspendu') {
            $this->status = 'suspendu';
            $this->dispatch('redirect-to-suspended');
            return;
        }

        // en_attente = email non vérifié (pas de validation admin)
        $this->status = 'email_not_verified';
    }

    public function render()
    {
        return view('livewire.auth.pending-status');
    }
}
