<?php

namespace App\Http\Livewire\Admin;

use App\Models\Admin;
use App\Models\Setting;
use Livewire\Component;
use Illuminate\Support\Facades\Hash;

class ParametreManager extends Component
{
    public string $plateformeNom = '';
    public string $plateformeDevise = 'XOF';
    public float $commissionPct = 10;
    public string $adminEmail = '';
    public string $adminCurrentPass = '';
    public string $adminNewPass = '';
    public string $adminConfirmPass = '';

    public function mount(): void
    {
        $settings = Setting::allAsArray();
        $this->plateformeNom = $settings['plateforme_nom'] ?? config('platform.name');
        $this->plateformeDevise = $settings['plateforme_devise'] ?? config('platform.currency');
        $this->commissionPct = (float) ($settings['commission_pct'] ?? config('platform.commission_pct'));
        $this->adminEmail = Admin::value('email') ?? '';
    }

    public function updatePlatform(): void
    {
        $this->validate([
            'plateformeNom' => 'required|string|max:100',
            'plateformeDevise' => 'required|string|max:10',
            'commissionPct' => 'required|numeric|min:0|max:100',
        ]);

        Setting::set('plateforme_nom', $this->plateformeNom, 'Nom de la plateforme');
        Setting::set('plateforme_devise', $this->plateformeDevise, 'Devise utilisée');
        Setting::set('commission_pct', $this->commissionPct, 'Commission globale (%)');
        session()->flash('success', 'Paramètres plateforme mis à jour.');
    }

    public function updateSecurity(): void
    {
        $rules = [
            'adminNewPass' => 'nullable|string|min:8',
            'adminConfirmPass' => 'nullable|string|same:adminNewPass',
        ];

        if ($this->adminNewPass) {
            $rules['adminCurrentPass'] = 'required|string';
        }

        $this->validate($rules);

        if ($this->adminNewPass) {
            if (!Hash::check($this->adminCurrentPass, auth('admin')->user()->password)) {
                $this->addError('adminCurrentPass', 'Le mot de passe actuel est incorrect.');
                return;
            }

            Admin::where('id', auth('admin')->id())->update([
                'password' => Hash::make($this->adminNewPass),
            ]);
        }

        $this->adminCurrentPass = '';
        $this->adminNewPass = '';
        $this->adminConfirmPass = '';
        session()->flash('success', 'Mot de passe administrateur mis à jour.');
    }

    public function render()
    {
        return view('livewire.admin.parametre-manager');
    }
}
