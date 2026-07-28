<?php

namespace Database\Seeders;

use App\Models\Hotspot;
use App\Models\Vendeur;
use Illuminate\Database\Seeder;

class HotspotSeeder extends Seeder
{
    public function run(): void
    {
        $admin = Vendeur::where('email', 'admin@wifipourtous.com')->first();
        if ($admin) {
            Hotspot::updateOrCreate(
                ['vendeur_id' => $admin->id, 'name' => 'Hotspot Principal'],
                ['description' => 'Hotspot principal de l\'administrateur', 'statut' => 'actif']
            );
            Hotspot::updateOrCreate(
                ['vendeur_id' => $admin->id, 'name' => 'Hotspot Bureau'],
                ['description' => 'Hotspot secondaire - bureau', 'statut' => 'actif']
            );
        }

        $amadou = Vendeur::where('email', 'amadou@test.com')->first();
        if ($amadou) {
            Hotspot::updateOrCreate(
                ['vendeur_id' => $amadou->id, 'name' => 'WiFi Amadou Centre'],
                ['description' => 'Hotspot centre-ville', 'statut' => 'actif']
            );
            Hotspot::updateOrCreate(
                ['vendeur_id' => $amadou->id, 'name' => 'WiFi Amadou Marché'],
                ['description' => 'Hotspot marché', 'statut' => 'actif']
            );
        }

        $fatima = Vendeur::where('email', 'fatima@test.com')->first();
        if ($fatima) {
            Hotspot::updateOrCreate(
                ['vendeur_id' => $fatima->id, 'name' => 'WiFi Fatima Quartier'],
                ['description' => 'Hotspot quartier résidentiel', 'statut' => 'actif']
            );
        }

        $rani = Vendeur::where('email', 'ranihamedt@gmail.com')->first();
        if ($rani) {
            Hotspot::updateOrCreate(
                ['vendeur_id' => $rani->id, 'name' => 'WiFi Rani Principal'],
                ['description' => 'Hotspot principal de Rani', 'statut' => 'actif']
            );
        }

        $ibrahim = Vendeur::where('email', 'ibrahim@test.com')->first();
        if ($ibrahim) {
            Hotspot::updateOrCreate(
                ['vendeur_id' => $ibrahim->id, 'name' => 'WiFi Ibrahim Route'],
                ['description' => 'Hotspot axe routier', 'statut' => 'actif']
            );
            Hotspot::updateOrCreate(
                ['vendeur_id' => $ibrahim->id, 'name' => 'WiFi Ibrahim Université'],
                ['description' => 'Hotspot zone universitaire', 'statut' => 'inactif']
            );
        }
    }
}
