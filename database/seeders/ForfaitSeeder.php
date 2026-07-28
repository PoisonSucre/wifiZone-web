<?php

namespace Database\Seeders;

use App\Models\Forfait;
use App\Models\Hotspot;
use App\Models\Vendeur;
use Illuminate\Database\Seeder;

class ForfaitSeeder extends Seeder
{
    public function run(): void
    {
        $admin = Vendeur::where('email', 'admin@wifipourtous.com')->first();
        if (!$admin) return;

        $hotspot = Hotspot::where('vendeur_id', $admin->id)->first();

        $forfaits = [
            ['label' => '1 Heure', 'montant' => 150, 'duree_minutes' => 60],
            ['label' => '5 Heures', 'montant' => 500, 'duree_minutes' => 300],
            ['label' => '24 Heures', 'montant' => 1000, 'duree_minutes' => 1440],
            ['label' => '3 Jours', 'montant' => 2500, 'duree_minutes' => 4320],
            ['label' => '7 Jours', 'montant' => 4000, 'duree_minutes' => 10080],
        ];

        foreach ($forfaits as $i => $f) {
            Forfait::updateOrCreate(
                ['vendeur_id' => $admin->id, 'label' => $f['label']],
                [
                    'montant' => $f['montant'],
                    'duree_minutes' => $f['duree_minutes'],
                    'ordre' => $i + 1,
                    'actif' => true,
                    'hotspot_id' => $hotspot?->id,
                ]
            );
        }
    }
}
