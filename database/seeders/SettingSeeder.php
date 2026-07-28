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
    }
}
