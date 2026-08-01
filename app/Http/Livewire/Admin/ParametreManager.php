<?php

namespace App\Http\Livewire\Admin;

use App\Models\Admin;
use App\Models\AdminLog;
use App\Models\Setting;
use Livewire\Component;
use Illuminate\Support\Facades\Hash;

class ParametreManager extends Component
{
    public string $activeTab = 'plateforme';
    public string $plateformeNom = '';
    public string $plateformeDevise = 'XOF';
    public float $commissionPct = 10;
    public string $adminEmail = '';
    public string $adminCurrentPass = '';
    public string $adminNewPass = '';
    public string $adminConfirmPass = '';

    public int $hotspotFreeSlots = 2;
    public int $hotspotPackDurationDays = 30;
    public array $hotspotPacks = [
        'A' => ['slots' => 2, 'price' => 5000, 'desc' => 'Idéal pour tester'],
        'B' => ['slots' => 4, 'price' => 7500, 'desc' => 'Le meilleur rapport qualité/prix'],
        'C' => ['slots' => 8, 'price' => 12000, 'desc' => 'Pour les gros volumes'],
    ];

    public function mount(): void
    {
        $settings = Setting::allAsArray();
        $this->plateformeNom = $settings['plateforme_nom'] ?? config('platform.name');
        $this->plateformeDevise = $settings['plateforme_devise'] ?? config('platform.currency');
        $this->commissionPct = (float) ($settings['commission_pct'] ?? config('platform.commission_pct'));
        $this->adminEmail = Admin::value('email') ?? '';

        $this->hotspotFreeSlots = (int) ($settings['hotspot_free_slots'] ?? 2);
        $this->hotspotPackDurationDays = (int) ($settings['hotspot_pack_duration_days'] ?? 30);

        foreach ($this->hotspotPacks as $key => $default) {
            $this->hotspotPacks[$key]['slots'] = (int) ($settings["hotspot_pack_{$key}_slots"] ?? $default['slots']);
            $this->hotspotPacks[$key]['price'] = (int) ($settings["hotspot_pack_{$key}_price"] ?? $default['price']);
            $this->hotspotPacks[$key]['desc'] = $settings["hotspot_pack_{$key}_desc"] ?? $default['desc'];
        }
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

        AdminLog::create([
            'admin_id' => auth('admin')->id(),
            'action' => 'update_platform',
            'target_type' => 'platform',
            'target_id' => null,
            'details' => "Plateforme: nom « {$this->plateformeNom} », devise « {$this->plateformeDevise} », commission {$this->commissionPct}%",
            'ip' => request()->ip(),
        ]);

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

            AdminLog::create([
                'admin_id' => auth('admin')->id(),
                'action' => 'update_security',
                'target_type' => 'admin',
                'target_id' => auth('admin')->id(),
                'details' => 'Mot de passe administrateur modifié',
                'ip' => request()->ip(),
            ]);
        }

        $this->adminCurrentPass = '';
        $this->adminNewPass = '';
        $this->adminConfirmPass = '';
        session()->flash('success', 'Mot de passe administrateur mis à jour.');
    }

    public function updateHotspots(): void
    {
        $this->validate([
            'hotspotFreeSlots' => 'required|integer|min:0',
            'hotspotPackDurationDays' => 'required|integer|min:1|max:365',
            'hotspotPacks.A.slots' => 'required|integer|min:1|max:1000',
            'hotspotPacks.A.slots' => 'required|integer|min:1|max:1000',
            'hotspotPacks.A.price' => 'required|integer|min:0',
            'hotspotPacks.A.desc' => 'required|string|max:100',
            'hotspotPacks.B.slots' => 'required|integer|min:1|max:1000',
            'hotspotPacks.B.price' => 'required|integer|min:0',
            'hotspotPacks.B.desc' => 'required|string|max:100',
            'hotspotPacks.C.slots' => 'required|integer|min:1|max:1000',
            'hotspotPacks.C.price' => 'required|integer|min:0',
            'hotspotPacks.C.desc' => 'required|string|max:100',
        ]);

        Setting::set('hotspot_free_slots', $this->hotspotFreeSlots, 'Hotspots gratuits par vendeur');
        Setting::set('hotspot_pack_duration_days', $this->hotspotPackDurationDays, 'Durée d\'un abonnement pack (jours)');

        foreach ($this->hotspotPacks as $key => $pack) {
            Setting::set("hotspot_pack_{$key}_slots", $pack['slots'], "Pack {$key} - hotspots ajoutés");
            Setting::set("hotspot_pack_{$key}_price", $pack['price'], "Pack {$key} - prix");
            Setting::set("hotspot_pack_{$key}_desc", $pack['desc'], "Pack {$key} - description");
        }

        AdminLog::create([
            'admin_id' => auth('admin')->id(),
            'action' => 'update_hotspot_packs',
            'target_type' => 'platform',
            'target_id' => null,
            'details' => "Hotspots gratuits: {$this->hotspotFreeSlots}, durée: {$this->hotspotPackDurationDays}j, packs: " . json_encode($this->hotspotPacks),
            'ip' => request()->ip(),
        ]);

        session()->flash('success', 'Paramètres hotspots mis à jour.');
    }

    public function render()
    {
        return view('livewire.admin.parametre-manager');
    }
}
