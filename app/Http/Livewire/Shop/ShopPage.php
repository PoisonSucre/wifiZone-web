<?php

namespace App\Http\Livewire\Shop;

use App\Models\Vendeur;
use Livewire\Component;

class ShopPage extends Component
{
    public int $vendeurId;
    public ?Vendeur $vendeur = null;
    public $forfaits = [];
    public ?int $selectedForfait = null;

    public function mount(int $id): void
    {
        $this->vendeurId = $id;
        $this->vendeur = Vendeur::active()->find($id);
        if (!$this->vendeur) abort(404);
        $this->forfaits = $this->vendeur->forfaits()->active()->ordered()->get()->toArray();
    }

    public function selectForfait(int $id): void
    {
        $this->selectedForfait = $id;
    }

    public function render() { return view('livewire.shop.shop-page'); }
}
