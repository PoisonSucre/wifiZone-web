<?php

namespace App\Http\Livewire\Vendor;

use Livewire\Component;

class ProfilEditor extends Component
{
    public string $nom = '';
    public string $prenom = '';
    public string $telephone = '';
    public string $adresse = '';
    public string $ville = '';
    public string $email = '';
    public string $newPassword = '';
    public string $confirmPassword = '';

    public bool $saved = false;

    public function mount(): void
    {
        $vendeur = auth()->user();
        $this->nom = $vendeur->nom;
        $this->prenom = $vendeur->prenom;
        $this->telephone = $vendeur->telephone;
        $this->adresse = $vendeur->adresse ?? '';
        $this->ville = $vendeur->ville ?? '';
        $this->email = $vendeur->email;
    }

    public function save(): void
    {
        $this->saved = false;

        $this->validate([
            'nom' => 'required|string|max:100',
            'prenom' => 'required|string|max:100',
            'telephone' => 'required|string|max:20',
            'newPassword' => 'nullable|string|min:6',
            'confirmPassword' => 'nullable|string|same:newPassword',
        ]);

        $vendeur = auth()->user();
        $data = [
            'nom' => $this->nom,
            'prenom' => $this->prenom,
            'telephone' => $this->telephone,
            'adresse' => $this->adresse,
            'ville' => $this->ville,
        ];
        if ($this->newPassword) {
            $data['password'] = $this->newPassword;
        }

        $vendeur->update($data);
        $this->newPassword = '';
        $this->confirmPassword = '';
        $this->saved = true;
    }

    public function render()
    {
        return view('livewire.vendor.profil-editor');
    }
}
