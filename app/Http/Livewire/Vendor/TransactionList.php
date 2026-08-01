<?php

namespace App\Http\Livewire\Vendor;

use App\Models\Transaction;
use App\Services\HotspotService;
use Livewire\Component;
use Livewire\WithPagination;

class TransactionList extends Component
{
    use WithPagination;

    public string $filterDate = '30j';
    public string $filterMethod = 'all';
    public string $filterPack = 'all';
    public string $search = '';

    protected $queryString = [
        'filterDate' => ['except' => '30j'],
        'filterMethod' => ['except' => 'all'],
        'filterPack' => ['except' => 'all'],
        'search' => ['except' => ''],
    ];

    public function updatingFilterDate(): void { $this->resetPage(); }
    public function updatingFilterMethod(): void { $this->resetPage(); }
    public function updatingFilterPack(): void { $this->resetPage(); }
    public function updatingSearch(): void { $this->resetPage(); }

    public function render()
    {
        $vendeur = auth()->user();
        $packs = app(HotspotService::class)->packs();

        $query = Transaction::where('vendeur_id', $vendeur->id)
            ->where('type', 'pack')
            ->orderByDesc('date_creation');

        // Date filter
        $dateRange = match ($this->filterDate) {
            '7j' => now()->subDays(7),
            '30j' => now()->subDays(30),
            '90j' => now()->subDays(90),
            'all' => null,
            default => null,
        };

        if ($dateRange) {
            $query->where('date_creation', '>=', $dateRange);
        }

        // Payment method filter
        if ($this->filterMethod !== 'all') {
            $query->where('payment_method', $this->filterMethod);
        }

        // Pack filter
        if ($this->filterPack !== 'all') {
            $query->where('pack_key', $this->filterPack);
        }

        // Search
        if ($this->search) {
            $s = $this->search;
            $query->where(function ($q) use ($s) {
                $q->where('pack_key', 'like', "%{$s}%")
                  ->orWhere('transaction_id', 'like', "%{$s}%")
                  ->orWhere('montant', 'like', "%{$s}%");
            });
        }

        // Paginate
        $transactions = $query->paginate(20);

        // Calculate slots and stats dynamically
        $transactions->getCollection()->transform(function ($t) use ($packs) {
            $t->slots = $packs[$t->pack_key]['slots'] ?? 0;
            return $t;
        });

        $totalAmount = (clone $query)->sum('montant');
        $totalCount = (clone $query)->count();
        $totalSlots = $transactions->getCollection()->sum('slots');

        return view('livewire.vendor.transaction-list', compact(
            'transactions', 'totalAmount', 'totalCount', 'totalSlots', 'packs'
        ));
    }
}