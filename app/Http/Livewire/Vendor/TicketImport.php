<?php

declare(strict_types=1);

namespace App\Http\Livewire\Vendor;

use App\Models\Forfait;
use App\Models\Hotspot;
use App\Services\TicketService;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithFileUploads;

class TicketImport extends Component
{
    use WithFileUploads;

    public int $currentStep = 1;
    public int $totalSteps = 3;
    public bool $hotspotPreselected = false;

    public int $hotspotId = 0;
    public int $forfaitId = 0;
    public $importFile = null;
    public ?string $importResult = null;
    public bool $importSuccess = false;

    public function mount(): void
    {
        $hs = (int) request()->query('hotspot', 0);
        if ($hs > 0) {
            $hotspot = Hotspot::where('id', $hs)->where('vendeur_id', auth()->id())->first();
            if ($hotspot) {
                $this->hotspotId = $hs;
                $this->hotspotPreselected = true;
                $this->currentStep = 2; // Skip directement au step forfait
            }
        }
    }

    public function goToStep(int $step): void
    {
        if ($step < 1 || $step > $this->totalSteps) return;
        if ($step > $this->currentStep) {
            if ($this->currentStep === 1 && $this->hotspotId <= 0) return;
            if ($this->currentStep === 2 && $this->forfaitId <= 0) return;
        }
        $this->currentStep = $step;
    }

    public function nextStep(): void
    {
        if ($this->currentStep === 1) {
            $this->validate([
                'hotspotId' => ['required', Rule::exists('hotspots', 'id')->where('vendeur_id', auth()->id())],
            ]);
            $this->currentStep = 2;
        } elseif ($this->currentStep === 2) {
            $this->validate([
                'forfaitId' => ['required', Rule::exists('vendor_forfaits', 'id')->where('vendeur_id', auth()->id())],
            ]);
            $this->currentStep = 3;
        }
    }

    public function previousStep(): void
    {
        if ($this->currentStep > 1) {
            $this->currentStep--;
        }
    }

    public function updatedHotspotId(): void
    {
        $this->forfaitId = 0;
    }

    public function importFile(): void
    {
        $vendeur = auth()->user();

        $this->validate([
            'importFile' => 'required|file|max:5120|mimes:csv,xlsx,xls',
            'hotspotId' => ['required', Rule::exists('hotspots', 'id')->where('vendeur_id', $vendeur->id)],
            'forfaitId' => ['required', Rule::exists('vendor_forfaits', 'id')->where('vendeur_id', $vendeur->id)],
        ]);

        $result = app(TicketService::class)->importFromMikhmon(
            $vendeur->id,
            $this->importFile,
            $this->forfaitId,
            $this->hotspotId
        );

        $this->importSuccess = $result['created'] > 0;
        $this->importResult = $result['message'];
        $this->importFile = null;

        $this->dispatch('toast', type: $this->importSuccess ? 'success' : 'warning', message: $result['message']);
    }

    public function resetImport(): void
    {
        $this->importResult = null;
        $this->importSuccess = false;
        $this->importFile = null;
        $this->currentStep = 3;
    }

    public function render()
    {
        $vendeur = auth()->user();
        $hotspots = $vendeur->hotspots()->orderBy('name')->get();

        $forfaits = collect();
        if ($this->hotspotId > 0) {
            $forfaits = Forfait::where('vendeur_id', $vendeur->id)
                ->where(function ($q) {
                    $q->where('hotspot_id', $this->hotspotId)->orWhereNull('hotspot_id');
                })
                ->where('actif', true)
                ->ordered()
                ->get();
        }

        return view('livewire.vendor.ticket-import', compact('hotspots', 'forfaits'));
    }
}
