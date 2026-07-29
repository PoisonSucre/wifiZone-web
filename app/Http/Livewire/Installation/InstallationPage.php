<?php

namespace App\Http\Livewire\Installation;

use Livewire\Component;

class InstallationPage extends Component
{
    public $selectedPack = null;

    protected $packs = [
        [
            'id' => 'starter',
            'nom' => 'Pack Starter',
            'sousTitre' => 'Pour démarrer votre activité',
            'prix' => '299 000',
            'prixNote' => 'FCFA',
            'equipements' => [
                'Routeur MikroTik hAP ax2 (WiFi 6)',
                'Antenne secteur 120° 16dBi',
                'Câble Ethernet extérieur 30m',
                'Boîtier étanche IP66',
                'Alimentation PoE + injecteur',
                'Fixations murales/poteau',
            ],
            'services' => [
                'Installation & configuration complète',
                'Configuration portail captif',
                'Test de couverture & optimisation',
                'Formation vendeur 1h',
                'Support technique 30 jours',
            ],
            'couleur' => '#10B981',
            'populaire' => false,
        ],
        [
            'id' => 'pro',
            'nom' => 'Pack Pro',
            'sousTitre' => 'Notre offre la plus complète',
            'prix' => '499 000',
            'prixNote' => 'FCFA',
            'equipements' => [
                'Routeur MikroTik hAP ax3 (WiFi 6E)',
                '2x Antennes secteur 120° 16dBi',
                'Câble Ethernet extérieur 50m',
                'Boîtier étanche IP66 renforcé',
                'Alimentation PoE + injecteur gigabit',
                'Fixations murales/poteau pro',
                'Onduleur 650VA (autonomie 2h)',
            ],
            'services' => [
                'Installation & configuration complète',
                'Configuration portail captif avancée',
                'Test de couverture & optimisation',
                'Formation vendeur 2h + doc',
                'Support technique 1 an',
                'Monitoring distant inclus 1 an',
                'Garantie matériel 2 ans',
            ],
            'couleur' => '#3B82F6',
            'populaire' => true,
        ],
        [
            'id' => 'enterprise',
            'nom' => 'Pack Entreprise',
            'sousTitre' => 'Pour zones larges & multi-sites',
            'prix' => 'Sur devis',
            'prixNote' => '',
            'equipements' => [
                'Routeur MikroTik CCR2004 ou supérieur',
                'Antennes secteurs 90°/120° selon étude',
                'Câblage complet (fibre/ethernet)',
                'Boîtiers étanches IP67 industriels',
                'Alimentations PoE++ redondées',
                'Matériel sur-mesure selon étude',
            ],
            'services' => [
                'Étude de couverture sur site (gratuit)',
                'Installation multi-points synchronisés',
                'Configuration portail captif centrale',
                'Formation équipe complète',
                'Support prioritaire 24/7 illimité',
                'Monitoring & alertes temps réel',
                'Maintenance préventive annuelle',
                'Garantie matériel 3 ans',
            ],
            'couleur' => '#8B5CF6',
            'populaire' => false,
        ],
    ];

    public function selectPack($packId)
    {
        $this->selectedPack = $packId;
    }

    public function render()
    {
        return view('livewire.installation.installation-page', [
            'packs' => $this->packs,
        ]);
    }
}