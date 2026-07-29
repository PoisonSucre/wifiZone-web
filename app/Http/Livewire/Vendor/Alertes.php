<?php

namespace App\Http\Livewire\Vendor;

use App\Models\Transaction;
use Livewire\Component;
use App\Http\Livewire\Vendor\Concerns\ChecksPendingPayments;

class Alertes extends Component
{
    use ChecksPendingPayments;

    public array $transactions = [];

    public function mount(): void
    {
        $this->loadTransactions();
    }

    public function refreshStuck(): void
    {
        $this->loadTransactions();
    }

    private function loadTransactions(): void
    {
        $vendeur = auth()->user();
        $this->transactions = Transaction::where('vendeur_id', $vendeur->id)
            ->where('statut', 'completed')
            ->whereNull('ticket_id')
            ->orderByDesc('date_creation')
            ->limit(50)
            ->select('id', 'statut', 'phone_number', 'montant', 'date_creation', 'token', 'ticket_id')
            ->get()
            ->toArray();
    }

    public function render()
    {
        return view('livewire.vendor.alertes')
            ->layout('layouts.vendor', ['title' => 'Alertes paiements']);
    }
}
