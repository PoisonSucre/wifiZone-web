<?php

namespace App\Http\Livewire\Vendor;

use App\Models\Hotspot;
use Illuminate\Validation\ValidationException;
use Livewire\Component;

class HotspotManager extends Component
{
    public string $hotspotName = '';
    public string $hotspotDescription = '';
    public string $mikrotikUrl = '';
    public ?int $editingHotspot = null;
    public bool $showDeleteModal = false;
    public ?int $deleteHotspotId = null;
    public bool $showForm = false;
    public bool $showToggleModal = false;
    public ?int $toggleHotspotId = null;

    protected $listeners = ['open-hotspot-form' => 'openForm'];

    public function openForm(): void
    {
        $this->resetForm();
        $this->showForm = true;
    }

    public function addHotspot(): void
    {
        try {
            $this->validate([
                'hotspotName' => 'required|string|max:150',
                'hotspotDescription' => 'nullable|string|max:500',
                'mikrotikUrl' => 'nullable|string|max:255',
            ]);

            Hotspot::create([
                'vendeur_id' => auth()->id(),
                'name' => $this->hotspotName,
                'description' => $this->hotspotDescription ?: null,
                'mikrotik_url' => $this->mikrotikUrl ?: null,
                'statut' => 'actif',
            ]);

            $this->resetForm();
            $this->dispatch('toast', type: 'success', message: 'Hotspot créé avec succès.');
        } catch (ValidationException $e) {
            throw $e;
        } catch (\Exception $e) {
            $this->dispatch('toast', type: 'error', message: 'Erreur lors de la création: ' . $e->getMessage());
        }
    }

    public function editHotspot(int $id): void
    {
        $hotspot = Hotspot::where('id', $id)->where('vendeur_id', auth()->id())->first();
        if ($hotspot) {
            $this->editingHotspot = $id;
            $this->hotspotName = $hotspot->name;
            $this->hotspotDescription = $hotspot->description ?? '';
            $this->mikrotikUrl = $hotspot->mikrotik_url ?? '';
            $this->showForm = true;
        }
    }

    public function updateHotspot(): void
    {
        try {
            $this->validate([
                'hotspotName' => 'required|string|max:150',
                'hotspotDescription' => 'nullable|string|max:500',
                'mikrotikUrl' => 'nullable|string|max:255',
            ]);

            Hotspot::where('id', $this->editingHotspot)
                ->where('vendeur_id', auth()->id())
                ->update([
                    'name' => $this->hotspotName,
                    'description' => $this->hotspotDescription ?: null,
                    'mikrotik_url' => $this->mikrotikUrl ?: null,
                ]);

            $this->resetForm();
            $this->dispatch('toast', type: 'success', message: 'Hotspot mis à jour.');
        } catch (ValidationException $e) {
            throw $e;
        } catch (\Exception $e) {
            $this->dispatch('toast', type: 'error', message: 'Erreur lors de la modification: ' . $e->getMessage());
        }
    }

    public function toggleHotspot(): void
    {
        $hotspot = Hotspot::where('id', $this->toggleHotspotId)->where('vendeur_id', auth()->id())->first();
        if ($hotspot) {
            $newStatut = $hotspot->statut === 'actif' ? 'inactif' : 'actif';
            $hotspot->update(['statut' => $newStatut]);
            $label = $newStatut === 'actif' ? 'activé' : 'désactivé';
            $this->dispatch('toast', type: 'success', message: "Hotspot « {$hotspot->name} » $label.");
            $this->dispatch('hotspot-status-changed', hotspotId: $this->toggleHotspotId, statut: $newStatut);
            $this->showToggleModal = false;
            $this->toggleHotspotId = null;
        }
    }

    public ?string $toggleHotspotName = '';

    public function confirmToggle(int $id): void
    {
        $hotspot = Hotspot::where('id', $id)->where('vendeur_id', auth()->id())->first();
        if ($hotspot) {
            $this->toggleHotspotId = $id;
            $this->toggleHotspotName = $hotspot->name;
            $this->showToggleModal = true;
        }
    }

    public function confirmDelete(int $id): void
    {
        $this->deleteHotspotId = $id;
        $this->showDeleteModal = true;
    }

    public function deleteHotspot(): void
    {
        try {
            Hotspot::where('id', $this->deleteHotspotId)
                ->where('vendeur_id', auth()->id())
                ->delete();
            $this->showDeleteModal = false;
            $this->deleteHotspotId = null;
            $this->dispatch('toast', type: 'success', message: 'Hotspot supprimé.');
        } catch (\Exception $e) {
            $this->dispatch('toast', type: 'error', message: 'Erreur lors de la suppression: ' . $e->getMessage());
        }
    }

    public function cancelEdit(): void
    {
        $this->resetForm();
    }

    private function resetForm(): void
    {
        $this->editingHotspot = null;
        $this->hotspotName = '';
        $this->hotspotDescription = '';
        $this->mikrotikUrl = '';
        $this->showForm = false;
    }

    public function render()
    {
        $hotspots = Hotspot::where('vendeur_id', auth()->id())
            ->withCount(['forfaits', 'tickets'])
            ->orderBy('created_at', 'desc')
            ->get();

        $totalHotspots = $hotspots->count();
        $actifs = $hotspots->where('statut', 'actif')->count();
        $inactifs = $totalHotspots - $actifs;

        return view('livewire.vendor.hotspot-manager', compact('hotspots', 'totalHotspots', 'actifs', 'inactifs'));
    }
}
