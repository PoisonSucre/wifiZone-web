<?php

namespace Database\Seeders;

use App\Models\HotspotSubscription;
use App\Models\Vendeur;
use App\Services\HotspotService;
use Illuminate\Database\Seeder;

class HotspotSubscriptionSeeder extends Seeder
{
    public function run(): void
    {
        $service = app(HotspotService::class);
        $packs = $service->packs();

        foreach (Vendeur::where('statut', 'actif')->cursor() as $vendeur) {
            $hotspotCount = $vendeur->hotspots()->count();
            $freeSlots = $service->freeSlots();

            if ($hotspotCount <= $freeSlots) {
                continue;
            }

            $paidSlotsNeeded = $hotspotCount - $freeSlots;

            $packKey = $this->choosePack($paidSlotsNeeded, $packs);
            if (!$packKey) {
                continue;
            }

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
                continue;
            }

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