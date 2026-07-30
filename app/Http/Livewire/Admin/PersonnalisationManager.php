<?php

namespace App\Http\Livewire\Admin;

use App\Models\Setting;
use Livewire\Component;

class PersonnalisationManager extends Component
{
    public string $whatsappNumber = '';
    public string $whatsappMessage = '';

    protected $defaultMessage = 'Bonjour, je suis intéréssé par le pack {pack_nom} du {pack_prix} {pack_prix_note} sur votre plateforme {platform_name}. Je peux avoir plus d\'informations ?';

    public function mount(): void
    {
        $settings = Setting::allAsArray();
        $this->whatsappNumber = $settings['whatsapp_number'] ?? '22662261391';
        $this->whatsappMessage = $settings['whatsapp_message'] ?? $this->defaultMessage;
    }

    public function save(): void
    {
        $this->validate([
            'whatsappNumber' => 'required|string|max:30',
            'whatsappMessage' => 'required|string|max:500',
        ]);

        Setting::set('whatsapp_number', $this->whatsappNumber, 'Numéro WhatsApp pour les demandes');
        Setting::set('whatsapp_message', $this->whatsappMessage, 'Template du message WhatsApp');
        session()->flash('success', 'Paramètres de personnalisation mis à jour.');
    }

    public function render()
    {
        return view('livewire.admin.personnalisation-manager');
    }
}
