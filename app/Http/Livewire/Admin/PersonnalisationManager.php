<?php

namespace App\Http\Livewire\Admin;

use App\Models\AdminLog;
use App\Models\Setting;
use Livewire\Component;

class PersonnalisationManager extends Component
{
    public string $activeTab = 'whatsapp';
    public bool $whatsappActif = true;
    public string $whatsappNumber = '';
    public string $whatsappMessage = '';

    public bool $packActif = true;
    public string $packNom = '';
    public string $packSousTitre = '';
    public string $packPrix = '';
    public string $packPrixNote = '';
    public string $packEquipements = '';
    public string $packServices = '';
    public string $packImage = '';

    protected $defaultMessage = 'Bonjour, je suis intéréssé par le pack {pack_nom} du {pack_prix} {pack_prix_note} sur votre plateforme {platform_name}. Je peux avoir plus d\'informations ?';

    public function mount(): void
    {
        $settings = Setting::allAsArray();
        $this->whatsappActif = ($settings['whatsapp_actif'] ?? '1') === '1';
        $this->whatsappNumber = $settings['whatsapp_number'] ?? '22662261391';
        $this->whatsappMessage = $settings['whatsapp_message'] ?? $this->defaultMessage;
        $this->packActif = ($settings['pack_actif'] ?? '1') === '1';

        $this->packNom = $settings['pack_nom'] ?? 'Pack WiFi Zone';
        $this->packSousTitre = $settings['pack_sous_titre'] ?? 'La solution clé en main pour votre hotspot';
        $this->packPrix = $settings['pack_prix'] ?? '120 000';
        $this->packPrixNote = $settings['pack_prix_note'] ?? 'FCFA';
        $this->packEquipements = $settings['pack_equipements'] ?? "Antenne (Tenda)\nMikrotik\nCablages";
        $this->packServices = $settings['pack_services'] ?? "Installation & configuration complète\nConfiguration portail captif\nTest de couverture & optimisation\nFormation vendeur 1h\nSupport technique 30 jours\nTickets personnalisé";
        $this->packImage = $settings['pack_image'] ?? 'Wifizone.png';
    }

    public function toggleWhatsapp(): void
    {
        $this->whatsappActif = !$this->whatsappActif;
        Setting::set('whatsapp_actif', $this->whatsappActif ? '1' : '0', 'Activer/désactiver WhatsApp');

        AdminLog::create([
            'admin_id' => auth('admin')->id(),
            'action' => 'toggle_whatsapp',
            'target_type' => 'setting',
            'target_id' => null,
            'details' => 'WhatsApp ' . ($this->whatsappActif ? 'activé' : 'désactivé'),
            'ip' => request()->ip(),
        ]);
    }

    public function togglePack(): void
    {
        $this->packActif = !$this->packActif;
        Setting::set('pack_actif', $this->packActif ? '1' : '0', 'Activer/désactiver le pack');

        AdminLog::create([
            'admin_id' => auth('admin')->id(),
            'action' => 'toggle_pack',
            'target_type' => 'setting',
            'target_id' => null,
            'details' => 'Pack installation ' . ($this->packActif ? 'activé' : 'désactivé'),
            'ip' => request()->ip(),
        ]);
    }

    public function save(): void
    {
        $rules = [
            'whatsappNumber' => 'required|string|max:30',
            'whatsappMessage' => 'required|string|max:500',
        ];

        if ($this->packActif) {
            $rules = array_merge($rules, [
                'packNom' => 'required|string|max:200',
                'packSousTitre' => 'required|string|max:300',
                'packPrix' => 'required|string|max:50',
                'packPrixNote' => 'required|string|max:50',
                'packEquipements' => 'required|string|max:1000',
                'packServices' => 'required|string|max:2000',
                'packImage' => 'required|string|max:500',
            ]);
        }

        $this->validate($rules);

        Setting::set('whatsapp_actif', $this->whatsappActif ? '1' : '0', 'Activer/désactiver WhatsApp');
        Setting::set('whatsapp_number', $this->whatsappNumber, 'Numéro WhatsApp pour les demandes');
        Setting::set('whatsapp_message', $this->whatsappMessage, 'Template du message WhatsApp');
        Setting::set('pack_actif', $this->packActif ? '1' : '0', 'Activer/désactiver le pack');
        Setting::set('pack_nom', $this->packNom, 'Nom du pack installation');
        Setting::set('pack_sous_titre', $this->packSousTitre, 'Sous-titre du pack');
        Setting::set('pack_prix', $this->packPrix, 'Prix du pack');
        Setting::set('pack_prix_note', $this->packPrixNote, 'Devise / note du prix');
        Setting::set('pack_equipements', $this->packEquipements, 'Équipements fournis (un par ligne)');
        Setting::set('pack_services', $this->packServices, 'Services inclus (un par ligne)');
        Setting::set('pack_image', $this->packImage, 'Image du pack');

        AdminLog::create([
            'admin_id' => auth('admin')->id(),
            'action' => 'update_personalisation',
            'target_type' => 'setting',
            'target_id' => null,
            'details' => "Personnalisation mise à jour (WhatsApp n° {$this->whatsappNumber}, pack « {$this->packNom} »)",
            'ip' => request()->ip(),
        ]);

        session()->flash('success', 'Paramètres de personnalisation mis à jour.');
    }

    public function render()
    {
        return view('livewire.admin.personnalisation-manager');
    }
}
