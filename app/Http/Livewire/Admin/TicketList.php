<?php

namespace App\Http\Livewire\Admin;

use App\Models\Ticket;
use App\Models\Vendeur;
use Livewire\Component;
use Livewire\WithPagination;

class TicketList extends Component
{
    use WithPagination;

    public ?int $filterVendeur = null;
    public string $filterStatut = '';
    public array $showPasswords = [];

    public function togglePassword(int $id): void
    {
        if (in_array($id, $this->showPasswords)) {
            $this->showPasswords = array_values(array_diff($this->showPasswords, [$id]));
        } else {
            $this->showPasswords[] = $id;
        }
    }

    public function render()
    {
        $query = Ticket::with('vendeur');
        if ($this->filterVendeur) {
            $query->where('vendeur_id', $this->filterVendeur);
        }
        if ($this->filterStatut) {
            $query->where('status', $this->filterStatut);
        }

        $tickets = $query->orderByDesc('id')->paginate(50);
        $vendeurs = Vendeur::select('id', 'nom', 'prenom')->orderBy('nom')->get();

        return view('livewire.admin.ticket-list', compact('tickets', 'vendeurs'));
    }
}
