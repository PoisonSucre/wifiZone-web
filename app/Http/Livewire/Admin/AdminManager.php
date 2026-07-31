<?php

namespace App\Http\Livewire\Admin;

use App\Http\Controllers\AdminAuthController;
use App\Models\Admin;
use App\Models\AdminLog;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithPagination;

class AdminManager extends Component
{
    use WithPagination;

    public string $prenom = '';
    public string $nom = '';
    public string $email = '';
    public bool $showDeleteModal = false;
    public ?int $deletingAdminId = null;

    protected $rules = [
        'prenom' => 'required|string|max:100',
        'nom' => 'required|string|max:100',
        'email' => 'required|email|unique:admins,email',
    ];

    public function addAdmin(): void
    {
        $this->validate();

        $admin = Admin::create([
            'prenom' => $this->prenom,
            'nom' => $this->nom,
            'email' => $this->email,
            'password' => Str::random(40),
        ]);

        AdminLog::create([
            'admin_id' => auth('admin')->id(),
            'action' => 'create_admin',
            'target_type' => 'admin',
            'target_id' => $admin->id,
            'details' => "Admin créé: {$admin->fullName()} ({$admin->email})",
            'ip' => request()->ip(),
        ]);

        app(AdminAuthController::class)->issuePasswordReset($admin);

        $this->reset(['prenom', 'nom', 'email']);
        session()->now('success', "Admin {$admin->fullName()} ajouté. Un email lui a été envoyé pour définir son mot de passe.");
    }

    public function openDeleteModal(int $id): void
    {
        $this->deletingAdminId = $id;
        $this->showDeleteModal = true;
    }

    public function closeDeleteModal(): void
    {
        $this->showDeleteModal = false;
        $this->deletingAdminId = null;
    }

    public function deleteAdmin(): void
    {
        $id = $this->deletingAdminId;
        if (! $id) {
            return;
        }

        if ($id === auth('admin')->id()) {
            session()->now('error', 'Vous ne pouvez pas supprimer votre propre compte.');
            $this->closeDeleteModal();
            return;
        }

        if (Admin::count() <= 1) {
            session()->now('error', 'Impossible de supprimer le dernier administrateur.');
            $this->closeDeleteModal();
            return;
        }

        $admin = Admin::find($id);
        if ($admin) {
            $name = $admin->fullName();
            AdminLog::create([
                'admin_id' => auth('admin')->id(),
                'action' => 'delete_admin',
                'target_type' => 'admin',
                'target_id' => $admin->id,
                'details' => "Admin supprimé: {$name} ({$admin->email})",
                'ip' => request()->ip(),
            ]);
            $admin->delete();
            session()->now('success', "Admin {$name} supprimé.");
        }

        $this->closeDeleteModal();
    }

    public function render()
    {
        $admins = Admin::orderBy('id')->paginate(20);
        $totalAdmins = Admin::count();
        $totalLogs = AdminLog::count();

        return view('livewire.admin.admin-manager', compact('admins', 'totalAdmins', 'totalLogs'));
    }
}
