<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    public function run(): void
    {
        Setting::set('plateforme_nom', 'Wifi Pour Tous', 'Nom de la plateforme');
        Setting::set('plateforme_devise', 'XOF', 'Devise utilisée');
        Setting::set('commission_pct', '10.00', 'Commission globale par défaut (%)');

        Setting::set('hotspot_free_slots', '2', 'Hotspots gratuits par vendeur');
        Setting::set('hotspot_pack_duration_days', '30', 'Durée d\'un abonnement pack (jours)');

        Setting::set('hotspot_pack_A_slots', '2', 'Pack A - hotspots ajoutés');
        Setting::set('hotspot_pack_A_price', '5000', 'Pack A - prix');
        Setting::set('hotspot_pack_A_desc', 'Idéal pour tester', 'Pack A - description');

        Setting::set('hotspot_pack_B_slots', '4', 'Pack B - hotspots ajoutés');
        Setting::set('hotspot_pack_B_price', '7500', 'Pack B - prix');
        Setting::set('hotspot_pack_B_desc', 'Le meilleur rapport qualité/prix', 'Pack B - description');

        Setting::set('hotspot_pack_C_slots', '8', 'Pack C - hotspots ajoutés');
        Setting::set('hotspot_pack_C_price', '12000', 'Pack C - prix');
        Setting::set('hotspot_pack_C_desc', 'Pour les gros volumes', 'Pack C - description');
    }
}
