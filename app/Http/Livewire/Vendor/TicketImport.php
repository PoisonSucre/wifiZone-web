<?php

declare(strict_types=1);

namespace App\Http\Livewire\Vendor;

use App\Models\Hotspot;
use App\Services\TicketService;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithFileUploads;

class TicketImport extends Component
{
    use WithFileUploads;

    public string $importMode = 'with_password';
    public $importFile = null;
    public ?string $importResult = null;
    public bool $importSuccess = false;
    public ?int $hotspotId = null;

    public function mount(): void
    {
        $hs = (int) request()->query('hotspot', 0);
        if ($hs > 0) {
            $this->hotspotId = $hs;
        }
    }

    public function importFile(): void
    {
        $vendeur = auth()->user();

        $this->validate([
            'importFile' => 'required|file|max:5120|mimes:csv,xlsx,xls',
            'importMode' => 'required|in:with_password,without_password',
            'hotspotId' => ['nullable', Rule::exists('hotspots', 'id')->where('vendeur_id', $vendeur->id)],
        ]);

        $result = app(TicketService::class)->importFromCsv(
            $vendeur->id,
            $this->importFile,
            $this->importMode,
            $this->hotspotId ?: null
        );

        $this->importSuccess = $result['created'] > 0;
        $this->importResult = $result['message'];
        $this->importFile = null;

        $this->dispatch('toast', type: $this->importSuccess ? 'success' : 'warning', message: $result['message']);
    }

    public function render()
    {
        $vendeur = auth()->user();
        $hotspots = $vendeur->hotspots()->orderBy('name')->get();
        return view('livewire.vendor.ticket-import', compact('hotspots'));
    }
}
