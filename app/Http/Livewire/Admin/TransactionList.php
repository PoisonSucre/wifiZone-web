<?php

namespace App\Http\Livewire\Admin;

use App\Models\Transaction;
use App\Models\Vendeur;
use Livewire\Component;
use Livewire\WithPagination;

class TransactionList extends Component
{
    use WithPagination;

    public ?int $filterVendeur = null;
    public string $filterStatut = '';

    public function render()
    {
        $query = Transaction::with('vendeur', 'ticket');

        if ($this->filterVendeur) {
            $query->where('vendeur_id', $this->filterVendeur);
        }
        if ($this->filterStatut) {
            $query->where('statut', $this->filterStatut);
        }

        $transactions = $query->orderByDesc('date_creation')->paginate(50);
        $vendeurs = Vendeur::select('id', 'nom', 'prenom')->orderBy('nom')->get();

        return view('livewire.admin.transaction-list', compact('transactions', 'vendeurs'));
    }
}
