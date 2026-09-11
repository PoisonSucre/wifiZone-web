<?php

namespace App\Http\Livewire\Vendor;

use App\Models\Hotspot;
use App\Models\Ticket;
use Livewire\Component;
use Livewire\WithPagination;

class TicketList extends Component
{
    use WithPagination;

    public string $filter = 'all';
    public string $search = '';
    public ?int $hotspotId = null;

    public function mount(): void
    {
        $hs = (int) request()->query('hotspot', 0);
        if ($hs > 0) {
            $this->hotspotId = $hs;
        }
    }

    public function updatingFilter(): void { $this->resetPage(); }
    public function updatingSearch(): void { $this->resetPage(); }
    public function updatingHotspotId(): void { $this->resetPage(); }

    public function render()
    {
        $vendeur = auth()->user();
        $hotspots = $vendeur->hotspots()->orderBy('name')->get();
        $hotspot = null;

        $query = Ticket::where('vendeur_id', $vendeur->id);

        if ($this->hotspotId) {
            $query->where('hotspot_id', $this->hotspotId);
            $hotspot = $vendeur->hotspots()->where('id', $this->hotspotId)->first();
        }

        if ($this->filter !== 'all') {
            $query->where('status', $this->filter);
        }

        if ($this->search) {
            $s = $this->search;
            $query->where(function ($q) use ($s) {
                $q->where('user', 'like', "%{$s}%")->orWhere('forfait', 'like', "%{$s}%");
            });
        }

        $tickets = $query->orderByDesc('id')->paginate(20);
        $nbDispo = $query->clone()->available()->count();
        $nbVendus = $query->clone()->sold()->count();

        $dispoParForfait = $query->clone()
            ->available()
            ->reorder()
            ->selectRaw('forfait, COUNT(*) as nb')
            ->groupBy('forfait')
            ->orderByDesc('nb')
            ->get();

        return view('livewire.vendor.ticket-list', compact('tickets', 'nbDispo', 'nbVendus', 'dispoParForfait', 'hotspots', 'hotspot'));
    }
}
