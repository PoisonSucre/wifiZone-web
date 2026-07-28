<?php

namespace App\Http\Livewire\Admin;

use App\Models\Vendeur;
use App\Notifications\VendorActivatedNotification;
use App\Notifications\VendorSuspendedNotification;
use Livewire\Component;
use Livewire\WithPagination;

class VendeurManager extends Component
{
    use WithPagination;

    public string $search = '';
    public bool $showAddModal = false;
    public string $newNom = '';
    public string $newPrenom = '';
    public string $newEmail = '';
    public string $newTelephone = '';
    public string $newPassword = '';
    public float $newCommission = 10;

    public ?int $editingCommissionId = null;
    public float $editingCommissionValue = 10;

    public bool $showConfirm = false;
    public ?int $confirmingId = null;
    public string $confirmMessage = '';
    public string $confirmAction = '';
    public string $confirmButtonText = 'Confirmer';
    public string $confirmButtonClass = 'bg-emerald-600 hover:bg-emerald-700';

    public function openConfirm(string $action, int $id, string $message, string $btnText = 'Confirmer', string $btnClass = 'bg-emerald-600 hover:bg-emerald-700'): void
    {
        $this->confirmAction = $action;
        $this->confirmingId = $id;
        $this->confirmMessage = $message;
        $this->confirmButtonText = $btnText;
        $this->confirmButtonClass = $btnClass;
        $this->showConfirm = true;
    }

    public function closeConfirm(): void
    {
        $this->showConfirm = false;
        $this->confirmingId = null;
        $this->confirmMessage = '';
        $this->confirmAction = '';
    }

    public function executeConfirm(): void
    {
        $id = $this->confirmingId;
        $action = $this->confirmAction;
        $this->closeConfirm();
        match ($action) {
            'activate' => $this->activate($id),
            'suspend' => $this->suspend($id),
            'delete' => $this->delete($id),
            default => null,
        };
    }

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function activate(int $id): void
    {
        $vendeur = Vendeur::findOrFail($id);
        $vendeur->update(['statut' => 'actif']);
        
        try {
            $vendeur->notify(new VendorActivatedNotification());
            session()->flash('success', 'Vendeur activé et notifié par email.');
        } catch (\Exception $e) {
            \Log::error('Erreur notification activation', ['email' => $vendeur->email, 'error' => $e->getMessage()]);
            session()->flash('success', 'Vendeur activé, mais erreur lors de l\'envoi de l\'email.');
        }
    }

    public function suspend(int $id): void
    {
        $vendeur = Vendeur::findOrFail($id);
        $vendeur->update(['statut' => 'suspendu']);
        
        try {
            $vendeur->notify(new VendorSuspendedNotification());
            session()->flash('success', 'Vendeur suspendu et notifié par email.');
        } catch (\Exception $e) {
            \Log::error('Erreur notification suspension', ['email' => $vendeur->email, 'error' => $e->getMessage()]);
            session()->flash('success', 'Vendeur suspendu, mais erreur lors de l\'envoi de l\'email.');
        }
    }

    public function delete(int $id): void
    {
        $vendeur = Vendeur::find($id);
        if ($vendeur && $vendeur->is_admin) {
            session()->flash('error', 'Impossible de supprimer un compte administrateur.');
            return;
        }
        Vendeur::where('id', $id)->delete();
        session()->flash('success', 'Vendeur supprimé.');
    }

    public function addVendeur(): void
    {
        $this->validate([
            'newNom' => 'required|string|max:100',
            'newPrenom' => 'required|string|max:100',
            'newEmail' => 'required|email|unique:vendeurs,email',
            'newTelephone' => 'required|string|max:20',
            'newPassword' => 'required|string|min:6',
            'newCommission' => 'nullable|numeric|min:0|max:100',
        ]);

        Vendeur::create([
            'nom' => $this->newNom,
            'prenom' => $this->newPrenom,
            'email' => $this->newEmail,
            'telephone' => $this->newTelephone,
            'password' => $this->newPassword,
            'statut' => 'actif',
            'commission_pct' => $this->newCommission ?? config('platform.commission_pct', 10),
            'card_number' => Vendeur::generateCardNumber(),
        ]);

        $this->showAddModal = false;
        $this->reset(['newNom', 'newPrenom', 'newEmail', 'newTelephone', 'newPassword']);
        $this->newCommission = 10;
        session()->flash('success', 'Vendeur créé.');
    }

    public function openCommissionModal(int $id, float $value): void
    {
        $this->editingCommissionId = $id;
        $this->editingCommissionValue = $value;
    }

    public function saveCommission(): void
    {
        Vendeur::where('id', $this->editingCommissionId)->update(['commission_pct' => $this->editingCommissionValue]);
        $this->editingCommissionId = null;
        session()->flash('success', 'Commission mise à jour.');
    }

    public function render()
    {
        $query = Vendeur::where('is_admin', false)
            ->withCount([
                'tickets as nb_vendus' => fn($q) => $q->where('status', 'vendu'),
                'tickets as nb_dispo' => fn($q) => $q->where('status', 'disponible'),
            ])
            ->withSum(['transactions as revenus' => fn($q) => $q->where('statut', 'completed')], 'montant');

        if ($this->search) {
            $s = $this->search;
            $query->where(function ($q) use ($s) {
                $q->where('nom', 'like', "%{$s}%")
                  ->orWhere('prenom', 'like', "%{$s}%")
                  ->orWhere('email', 'like', "%{$s}%")
                  ->orWhere('telephone', 'like', "%{$s}%");
            });
        }

        $vendeurs = $query->orderByDesc('date_inscription')->paginate(20);
        return view('livewire.admin.vendeur-manager', compact('vendeurs'));
    }
}
