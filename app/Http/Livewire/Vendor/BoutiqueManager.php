<?php

namespace App\Http\Livewire\Vendor;

use App\Models\Forfait;
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
    public bool $showDeleteModal = false;
    public ?int $deleteForfaitId = null;

    public function mount(): void
    {
        $vendeur = auth()->user();
        $this->couleur = $vendeur->couleur ?? '#1ca04e';
        $this->couleurTop = $vendeur->couleur_top ?? '#110904';
        $this->nomPortail = $vendeur->nom_portail ?? '';
        $this->messageBienvenue = $vendeur->message_bienvenue ?? '';

        $this->cleanupPreviewSession();
    }

    public function updatedCouleur($value): void
    {
        session(['preview_couleur' => $value]);
    }

    public function updatedCouleurTop($value): void
    {
        session(['preview_couleur_top' => $value]);
    }

    public function updatedNomPortail($value): void
    {
        session(['preview_nom_portail' => $value]);
    }

    public function updatedMessageBienvenue($value): void
    {
        session(['preview_message' => $value]);
    }

    public function updatedLogo(): void
    {
        try {
            $this->validate(['logo' => 'image|mimes:jpeg,png,gif,webp|max:2048']);

            $this->cleanupTempLogo();

            $ext = $this->logo->getClientOriginalExtension();
            $filename = 'preview_logo_' . auth()->id() . '_' . Str::random(16) . '.' . $ext;
            $this->logo->storeAs('public/tmp/preview', $filename);
            session(['preview_logo' => 'storage/tmp/preview/' . $filename]);
        } catch (ValidationException $e) {
            throw $e;
        } catch (\Exception $e) {
            $this->dispatch('toast', type: 'error', message: 'Erreur lors du téléchargement du logo: ' . $e->getMessage());
        }
    }

    public function updateShop(): void
    {
        try {
            $vendeur = auth()->user();
            $data = [
                'couleur' => session('preview_couleur', $this->couleur),
                'couleur_top' => session('preview_couleur_top', $this->couleurTop),
                'nom_portail' => session('preview_nom_portail', $this->nomPortail),
                'message_bienvenue' => session('preview_message', $this->messageBienvenue),
            ];

            $previewLogo = session('preview_logo');
            if ($previewLogo && file_exists(public_path($previewLogo))) {
                $ext = pathinfo($previewLogo, PATHINFO_EXTENSION);
                $permanent = 'assets/uploads/logos/logo_' . $vendeur->id . '.' . $ext;
                if ($vendeur->logo && file_exists(public_path($vendeur->logo))) {
                    unlink(public_path($vendeur->logo));
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
                if ($vendeur->logo && file_exists(public_path($vendeur->logo))) {
                    unlink(public_path($vendeur->logo));
                }
                $ext = $this->logo->getClientOriginalExtension();
                $filename = 'logo_' . $vendeur->id . '.' . $ext;
                $destPath = public_path('assets/uploads/logos/' . $filename);
                if (!is_dir(dirname($destPath))) {
                    mkdir(dirname($destPath), 0755, true);
                }
                $this->logo->move(dirname($destPath), $filename);
                $data['logo'] = 'assets/uploads/logos/' . $filename;
            }

            $vendeur->update($data);
            $this->cleanupPreviewSession();
            $this->dispatch('toast', type: 'success', message: 'Boutique mise à jour.');
        } catch (ValidationException $e) {
            throw $e;
        } catch (\Exception $e) {
            $this->dispatch('toast', type: 'error', message: 'Erreur lors de la mise à jour: ' . $e->getMessage());
        }
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
                'label' => $this->forfaitLabel,
                'montant' => $this->forfaitMontant,
                'duree_minutes' => $this->forfaitDuree,
                'ordre' => $maxOrdre + 1,
            ]);

            $this->resetForfaitForm();
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

    public function cancelEdit(): void { $this->resetForfaitForm(); }

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
        session()->forget(['preview_couleur', 'preview_couleur_top', 'preview_nom_portail', 'preview_message', 'preview_logo']);
    }

    private function cleanupTempLogo(): void
    {
        $previewLogo = session('preview_logo');
        if ($previewLogo && Storage::exists(str_replace('storage/', 'public/', $previewLogo))) {
            Storage::delete(str_replace('storage/', 'public/', $previewLogo));
        }
    }

    public function render()
    {
        $vendeur = auth()->user();
        $forfaits = Forfait::where('vendeur_id', $vendeur->id)->orderBy('ordre')->get();
        $hotspots = $vendeur->hotspots()->orderBy('name')->get();
        $hotspotId = (int) request()->query('hotspot', 0);
        return view('livewire.vendor.boutique-manager', compact('vendeur', 'forfaits', 'hotspots', 'hotspotId'));
    }
}
