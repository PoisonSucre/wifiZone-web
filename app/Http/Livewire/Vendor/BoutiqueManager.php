<?php

namespace App\Http\Livewire\Vendor;

use App\Models\Forfait;
use App\Models\Hotspot;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Livewire\Component;
use Livewire\WithFileUploads;

class BoutiqueManager extends Component
{
    use WithFileUploads;

    public string $couleur = '#1ca04e';
    public string $couleurTop = '#110904';
    public string $nomPortail = '';
    public string $messageBienvenue = '';
    public $logo = null;
    public ?int $editingForfait = null;
    public string $forfaitLabel = '';
    public int $forfaitMontant = 0;
    public int $forfaitDuree = 60;
    public bool $showForfaitModal = false;
    public bool $showDeleteModal = false;
    public ?int $deleteForfaitId = null;
    public ?int $hotspotId = null;

    private function previewKey(string $key): string
    {
        return $this->hotspotId ? "preview_{$key}_{$this->hotspotId}" : "preview_{$key}";
    }

    public function mount(): void
    {
        $hs = (int) request()->query('hotspot', 0);
        if ($hs > 0) {
            $this->hotspotId = $hs;
        }

        if ($this->hotspotId) {
            $hotspot = Hotspot::where('id', $this->hotspotId)->where('vendeur_id', auth()->id())->first();
            if ($hotspot) {
                $this->couleur = $hotspot->couleur;
                $this->couleurTop = $hotspot->couleur_top;
                $this->nomPortail = $hotspot->nom_portail;
                $this->messageBienvenue = $hotspot->message_bienvenue ?? '';
            }
        } else {
            $vendeur = auth()->user();
            $this->couleur = $vendeur->couleur ?? '#1ca04e';
            $this->couleurTop = $vendeur->couleur_top ?? '#110904';
            $this->nomPortail = $vendeur->nom_portail ?? '';
            $this->messageBienvenue = $vendeur->message_bienvenue ?? '';
        }

        $this->cleanupPreviewSession();
    }

    public function updatedCouleur($value): void
    {
        session([$this->previewKey('couleur') => $value]);
    }

    public function updatedCouleurTop($value): void
    {
        session([$this->previewKey('couleur_top') => $value]);
    }

    public function updatedNomPortail($value): void
    {
        session([$this->previewKey('nom_portail') => $value]);
    }

    public function updatedMessageBienvenue($value): void
    {
        session([$this->previewKey('message') => $value]);
    }

    public function updatedLogo(): void
    {
        try {
            $this->validate(['logo' => 'image|mimes:jpeg,png,gif,webp|max:2048']);

            $this->cleanupTempLogo();

            $ext = $this->logo->getClientOriginalExtension();
            $prefix = $this->hotspotId ? 'preview_logo_' . auth()->id() . '_hs' . $this->hotspotId : 'preview_logo_' . auth()->id();
            $filename = $prefix . '_' . Str::random(16) . '.' . $ext;
            $this->logo->storeAs('public/tmp/preview', $filename);
            session([$this->previewKey('logo') => 'storage/tmp/preview/' . $filename]);
        } catch (ValidationException $e) {
            throw $e;
        } catch (\Exception $e) {
            $this->dispatch('toast', type: 'error', message: 'Erreur lors du téléchargement du logo: ' . $e->getMessage());
        }
    }

    public function updateShop(): void
    {
        try {
            $previewCouleur = session($this->previewKey('couleur'), $this->couleur);
            $previewCouleurTop = session($this->previewKey('couleur_top'), $this->couleurTop);
            $previewNomPortail = session($this->previewKey('nom_portail'), $this->nomPortail);
            $previewMessage = session($this->previewKey('message'), $this->messageBienvenue);
            $previewLogo = session($this->previewKey('logo'));

            $data = [
                'couleur' => $previewCouleur,
                'couleur_top' => $previewCouleurTop,
                'nom_portail' => $previewNomPortail,
                'message_bienvenue' => $previewMessage,
            ];

            if ($previewLogo && file_exists(public_path($previewLogo))) {
                $ext = pathinfo($previewLogo, PATHINFO_EXTENSION);
                $suffix = $this->hotspotId ? 'hs' . $this->hotspotId : 'v' . auth()->id();
                $permanent = 'assets/uploads/logos/logo_' . $suffix . '.' . $ext;

                $oldField = $this->hotspotId
                    ? Hotspot::where('id', $this->hotspotId)->value('logo')
                    : auth()->user()->logo;

                if ($oldField && file_exists(public_path($oldField))) {
                    unlink(public_path($oldField));
                }

                $tmpPath = public_path($previewLogo);
                $destPath = public_path($permanent);
                if (!is_dir(dirname($destPath))) {
                    mkdir(dirname($destPath), 0755, true);
                }
                rename($tmpPath, $destPath);
                $data['logo'] = $permanent;
            } elseif ($this->logo) {
                $this->validate(['logo' => 'image|mimes:jpeg,png,gif,webp|max:2048']);

                $suffix = $this->hotspotId ? 'hs' . $this->hotspotId : 'v' . auth()->id();

                $oldField = $this->hotspotId
                    ? Hotspot::where('id', $this->hotspotId)->value('logo')
                    : auth()->user()->logo;

                if ($oldField && file_exists(public_path($oldField))) {
                    unlink(public_path($oldField));
                }

                $ext = $this->logo->getClientOriginalExtension();
                $filename = 'logo_' . $suffix . '.' . $ext;
                $destPath = public_path('assets/uploads/logos/' . $filename);
                if (!is_dir(dirname($destPath))) {
                    mkdir(dirname($destPath), 0755, true);
                }
                $this->logo->move(dirname($destPath), $filename);
                $data['logo'] = 'assets/uploads/logos/' . $filename;
            }

            if ($this->hotspotId) {
                Hotspot::where('id', $this->hotspotId)->where('vendeur_id', auth()->id())->update($data);
            } else {
                auth()->user()->update($data);
            }

            $this->cleanupPreviewSession();
            $this->dispatch('toast', type: 'success', message: 'Boutique mise à jour.');
        } catch (ValidationException $e) {
            throw $e;
        } catch (\Exception $e) {
            $this->dispatch('toast', type: 'error', message: 'Erreur lors de la mise à jour: ' . $e->getMessage());
        }
    }

    public function openAddForfaitModal(): void
    {
        $this->resetForfaitForm();
        $this->showForfaitModal = true;
    }

    public function addForfait(): void
    {
        try {
            $this->validate([
                'forfaitLabel' => 'required|string|max:50',
                'forfaitMontant' => 'required|integer|min:1',
                'forfaitDuree' => 'required|integer|min:1',
            ]);

            $vendeur = auth()->user();
            $maxOrdre = Forfait::where('vendeur_id', $vendeur->id)->max('ordre') ?? 0;

            Forfait::create([
                'vendeur_id' => $vendeur->id,
                'hotspot_id' => $this->hotspotId,
                'label' => $this->forfaitLabel,
                'montant' => $this->forfaitMontant,
                'duree_minutes' => $this->forfaitDuree,
                'ordre' => $maxOrdre + 1,
            ]);

            $this->resetForfaitForm();
            $this->showForfaitModal = false;
            $this->dispatch('toast', type: 'success', message: 'Forfait ajouté.');
        } catch (ValidationException $e) {
            throw $e;
        } catch (\Exception $e) {
            $this->dispatch('toast', type: 'error', message: 'Erreur lors de l\'ajout: ' . $e->getMessage());
        }
    }

    public function editForfait(int $id): void
    {
        $forfait = Forfait::where('id', $id)->where('vendeur_id', auth()->id())->first();
        if ($forfait) {
            $this->editingForfait = $id;
            $this->forfaitLabel = $forfait->label;
            $this->forfaitMontant = $forfait->montant;
            $this->forfaitDuree = $forfait->duree_minutes;
            $this->showForfaitModal = true;
        }
    }

    public function updateForfait(): void
    {
        try {
            $this->validate([
                'forfaitLabel' => 'required|string|max:50',
                'forfaitMontant' => 'required|integer|min:1',
                'forfaitDuree' => 'required|integer|min:1',
            ]);

            Forfait::where('id', $this->editingForfait)->where('vendeur_id', auth()->id())->update([
                'label' => $this->forfaitLabel,
                'montant' => $this->forfaitMontant,
                'duree_minutes' => $this->forfaitDuree,
            ]);

            $this->resetForfaitForm();
            $this->showForfaitModal = false;
            $this->dispatch('toast', type: 'success', message: 'Forfait mis à jour.');
        } catch (ValidationException $e) {
            throw $e;
        } catch (\Exception $e) {
            $this->dispatch('toast', type: 'error', message: 'Erreur lors de la modification: ' . $e->getMessage());
        }
    }

    public function toggleForfait(int $id): void
    {
        $forfait = Forfait::where('id', $id)->where('vendeur_id', auth()->id())->first();
        if ($forfait) {
            $forfait->update(['actif' => !$forfait->actif]);
            $status = $forfait->actif ? 'activé' : 'désactivé';
            $this->dispatch('toast', type: 'success', message: "Forfait « {$forfait->label} » $status.");
        }
    }

    public function confirmDelete(int $id): void
    {
        $this->deleteForfaitId = $id;
        $this->showDeleteModal = true;
    }

    public function deleteForfait(): void
    {
        try {
            Forfait::where('id', $this->deleteForfaitId)->where('vendeur_id', auth()->id())->delete();
            $this->showDeleteModal = false;
            $this->deleteForfaitId = null;
            $this->dispatch('toast', type: 'success', message: 'Forfait supprimé.');
        } catch (ValidationException $e) {
            throw $e;
        } catch (\Exception $e) {
            $this->dispatch('toast', type: 'error', message: 'Erreur lors de la suppression: ' . $e->getMessage());
        }
    }

    public function cancelEdit(): void
    {
        $this->resetForfaitForm();
        $this->showForfaitModal = false;
    }

    private function resetForfaitForm(): void
    {
        $this->editingForfait = null;
        $this->forfaitLabel = '';
        $this->forfaitMontant = 0;
        $this->forfaitDuree = 60;
    }

    private function cleanupPreviewSession(): void
    {
        $this->cleanupTempLogo();
        $keys = ['couleur', 'couleur_top', 'nom_portail', 'message', 'logo'];
        $prefixed = array_map(fn ($k) => $this->previewKey($k), $keys);
        session()->forget($prefixed);
    }

    private function cleanupTempLogo(): void
    {
        $previewLogo = session($this->previewKey('logo'));
        if ($previewLogo && Storage::exists(str_replace('storage/', 'public/', $previewLogo))) {
            Storage::delete(str_replace('storage/', 'public/', $previewLogo));
        }
    }

    public function render()
    {
        $vendeur = auth()->user();
        $forfaits = Forfait::where('vendeur_id', $vendeur->id)
            ->when($this->hotspotId, fn ($q) => $q->where('hotspot_id', $this->hotspotId))
            ->orderBy('ordre')
            ->get();
        $hotspots = $vendeur->hotspots()->orderBy('name')->get();
        return view('livewire.vendor.boutique-manager', compact('vendeur', 'forfaits', 'hotspots'));
    }
}
