<?php

namespace Database\Seeders;

use App\Models\Hotspot;
use App\Models\HotspotSubscription;
use App\Models\Vendeur;
use App\Services\HotspotService;
use Illuminate\Database\Seeder;

class HotspotSeeder extends Seeder
{
    public function run(): void
    {
        $service = app(HotspotService::class);
        $packs = $service->packs();

        $vendors = [
            Vendeur::where('email', 'admin@wifipourtous.com')->first(),
            Vendeur::where('email', 'amadou@test.com')->first(),
            Vendeur::where('email', 'fatima@test.com')->first(),
            Vendeur::where('email', 'ranihamedt@gmail.com')->first(),
            Vendeur::where('email', 'ibrahim@test.com')->first(),
        ];

        $hotspotData = [
            [
                'vendors' => [0],
                'hotspots' => [
                    ['name' => 'Hotspot Principal', 'description' => 'Hotspot principal de l\'administrateur', 'statut' => 'actif'],
                    ['name' => 'Hotspot Bureau', 'description' => 'Hotspot secondaire - bureau', 'statut' => 'actif'],
                ],
            ],
            [
                'vendors' => [1],
                'hotspots' => [
                    ['name' => 'WiFi Amadou Centre', 'description' => 'Hotspot centre-ville', 'statut' => 'actif'],
                    ['name' => 'WiFi Amadou Marché', 'description' => 'Hotspot marché', 'statut' => 'actif'],
                ],
            ],
            [
                'vendors' => [2],
                'hotspots' => [
                    ['name' => 'WiFi Fatima Quartier', 'description' => 'Hotspot quartier résidentiel', 'statut' => 'actif'],
                ],
            ],
            [
                'vendors' => [3],
                'hotspots' => [
                    ['name' => 'WiFi Rani Principal', 'description' => 'Hotspot principal de Rani', 'statut' => 'actif'],
                ],
            ],
            [
                'vendors' => [4],
                'hotspots' => [
                    ['name' => 'WiFi Ibrahim Route', 'description' => 'Hotspot axe routier', 'statut' => 'actif'],
                    ['name' => 'WiFi Ibrahim Université', 'description' => 'Hotspot zone universitaire', 'statut' => 'inactif'],
                ],
            ],
        ];

        foreach ($hotspotData as $group) {
            foreach ($group['vendors'] as $vendorIndex) {
                $vendeur = $vendors[$vendorIndex] ?? null;
                if (!$vendeur) continue;

                foreach ($group['hotspots'] as $hs) {
                    Hotspot::updateOrCreate(
                        ['vendeur_id' => $vendeur->id, 'name' => $hs['name']],
                        ['description' => $hs['description'], 'statut' => $hs['statut']]
                    );
                }

                $hotspotCount = $vendeur->hotspots()->count();
                $freeSlots = $service->freeSlots();

                if ($hotspotCount > $freeSlots) {
                    $paidSlotsNeeded = $hotspotCount - $freeSlots;
                    $packKey = $this->choosePack($paidSlotsNeeded, $packs);

                    if ($packKey) {
                        $pack = $packs[$packKey];
                        $existing = HotspotSubscription::where('vendeur_id', $vendeur->id)
                            ->where('pack_key', $packKey)
                            ->whereNotNull('frozen_at')
                            ->orderByDesc('frozen_at')
                            ->first();

                        if ($existing) {
                            $existing->unfreeze();
                            $existing->update([
                                'slots' => $pack['slots'],
                                'montant' => $pack['price'],
                                'payment_method' => 'solde',
                                'starts_at' => now(),
                                'expires_at' => now()->addDays($service->packDurationDays()),
                            ]);
                        } else {
                            $latest = HotspotSubscription::where('vendeur_id', $vendeur->id)
                                ->where('expires_at', '>', now())
                                ->orderByDesc('expires_at')
                                ->value('expires_at');

                            $base = $latest ? \Carbon\Carbon::parse($latest) : now();

                            HotspotSubscription::create([
                                'vendeur_id' => $vendeur->id,
                                'pack_key' => $packKey,
                                'slots' => $pack['slots'],
                                'montant' => $pack['price'],
                                'payment_method' => 'solde',
                                'starts_at' => now(),
                                'expires_at' => $base->copy()->addDays($service->packDurationDays()),
                            ]);
                        }
                    }
                }
            }
        }
    }

    private function choosePack(int $slotsNeeded, array $packs): ?string
    {
        foreach ($packs as $key => $pack) {
            if ($pack['slots'] >= $slotsNeeded) {
                return $key;
            }
        }

        return 'C';
    }
}
