<?php

namespace App\Http\Livewire\Auth;

use App\Models\Vendeur;
use Livewire\Component;

class SuspendedStatus extends Component
{
    public ?string $status = null;

    public function checkStatus(): void
    {
        $this->pollStatus();
    }

    public function pollStatus(): void
    {
        $email = session('suspended_vendor_email');

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

        if ($vendeur->statut === 'en_attente') {
            $this->status = 'en_attente';
            $this->dispatch('redirect-to-pending');
            return;
        }

        $this->status = 'suspendu';
    }

    public function render()
    {
        return view('livewire.auth.suspended-status');
    }
}
