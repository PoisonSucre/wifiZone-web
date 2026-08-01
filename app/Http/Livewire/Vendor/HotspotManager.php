<?php

namespace App\Http\Livewire\Vendor;

use App\Models\Hotspot;
use App\Models\Transaction;
use App\Services\HotspotService;
use Illuminate\Support\Facades\DB;
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
    public ?string $toggleHotspotName = '';
    public ?string $soldePackKey = null;
    public bool $showPackModal = false;
    public bool $showRenewBanner = false;
    public ?string $renewPackKey = null;

    protected $listeners = ['open-hotspot-form' => 'openForm'];

    public function openForm(): void
    {
        $service = app(HotspotService::class);
        $vendeur = auth()->user();

        $service->freezeExpiredSubscriptions($vendeur);

        if (!$service->canCreate($vendeur)) {
            $this->dispatch('toast', type: 'error', message: 'Quota de hotspots atteint. Abonnez-vous à un pack pour en ajouter.');
            $this->openPackModal();
            return;
        }

        $this->resetForm();
        $this->showForm = true;
    }

    public function openPackModal(): void
    {
        $this->showPackModal = true;
    }

    public function closePackModal(): void
    {
        $this->showPackModal = false;
    }

    public function checkFrozen(): void
    {
        $service = app(HotspotService::class);
        $service->freezeExpiredSubscriptions(auth()->user());
        $this->showRenewBanner = $service->hasFrozen(auth()->user());
    }

    public function openRenewModal(string $packKey): void
    {
        $this->renewPackKey = $packKey;
        $this->showRenewBanner = false;
        $this->showPackModal = true;
    }

    public function closeRenewModal(): void
    {
        $this->renewPackKey = null;
    }

    public function addHotspot(): void
    {
        try {
            if (!app(HotspotService::class)->canCreate(auth()->user())) {
                $this->dispatch('toast', type: 'error', message: 'Quota de hotspots atteint.');
                return;
            }

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

    public function chooseSoldePack(string $packKey): void
    {
        $service = app(HotspotService::class);
        $pack = $service->pack($packKey);

        if (!$pack) {
            $this->dispatch('toast', type: 'error', message: 'Pack inconnu.');
            return;
        }

        $this->soldePackKey = $packKey;
        $this->showPackModal = false;
    }

    public function cancelSoldePack(): void
    {
        $this->soldePackKey = null;
        $this->showPackModal = true;
    }

    public function subscribePackWithSolde(): void
    {
        $service = app(HotspotService::class);
        $vendeur = auth()->user();
        $pack = $service->pack($this->soldePackKey ?? '');

        if (!$pack) {
            $this->dispatch('toast', type: 'error', message: 'Pack inconnu.');
            return;
        }

        if ($service->soldeDisponible($vendeur) < $pack['price']) {
            $this->dispatch('toast', type: 'error', message: 'Solde insuffisant pour ce pack.');
            return;
        }

        try {
            DB::transaction(function () use ($service, $vendeur, $pack) {
                $vendeur->lockForUpdate();

                if ($service->soldeDisponible($vendeur) < $pack['price']) {
                    throw new \RuntimeException('Solde insuffisant.');
                }

                Transaction::create([
                    'vendeur_id' => $vendeur->id,
                    'transaction_id' => app(\App\Services\LigdiCashService::class)->generateTransactionId(),
                    'montant' => $pack['price'],
                    'statut' => 'completed',
                    'type' => 'pack',
                    'payment_method' => 'solde',
                    'pack_key' => $pack['key'],
                ]);

                $service->renewSubscription($vendeur, $pack['key'], 'solde');
            });
        } catch (\RuntimeException $e) {
            $this->dispatch('toast', type: 'error', message: $e->getMessage());
            return;
        } catch (\Exception $e) {
            $this->dispatch('toast', type: 'error', message: 'Erreur lors de l\'abonnement: ' . $e->getMessage());
            return;
        }

        $this->soldePackKey = null;
        $this->dispatch('toast', type: 'success', message: "Pack {$pack['key']} renouvelé avec votre solde.");
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
        $vendeur = auth()->user();
        $service = app(HotspotService::class);

        $service->freezeExpiredSubscriptions($vendeur);

        $hotspots = Hotspot::where('vendeur_id', $vendeur->id)
            ->withCount(['forfaits', 'tickets'])
            ->orderBy('created_at', 'desc')
            ->get();

        $totalHotspots = $hotspots->count();
        $actifs = $hotspots->where('statut', 'actif')->count();
        $inactifs = $totalHotspots - $actifs;

        $packs = $service->packs();
        $limit = $service->limit($vendeur);
        $used = $service->usedSlots($vendeur);
        $remaining = $service->remaining($vendeur);
        $canCreate = $service->canCreate($vendeur);
        $soldeDisponible = $service->soldeDisponible($vendeur);
        $subscriptions = $service->activeSubscriptions($vendeur);
        $frozenSubscriptions = $service->frozenSubscriptions($vendeur);
        $hasFrozen = $service->hasFrozen($vendeur);

        $this->showRenewBanner = $hasFrozen;

        return view('livewire.vendor.hotspot-manager', compact(
            'hotspots', 'totalHotspots', 'actifs', 'inactifs',
            'packs', 'limit', 'used', 'remaining', 'canCreate',
            'soldeDisponible', 'subscriptions', 'frozenSubscriptions', 'hasFrozen'
        ));
    }
}
