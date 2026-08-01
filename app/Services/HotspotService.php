<?php

namespace App\Services;

use App\Models\HotspotSubscription;
use App\Models\Transaction;
use App\Models\Vendeur;
use Illuminate\Support\Carbon;

class HotspotService
{
    public const PACK_KEYS = ['A', 'B', 'C'];

    public function freeSlots(): int
    {
        return max(0, (int) \App\Models\Setting::get('hotspot_free_slots', 2));
    }

    public function packDurationDays(): int
    {
        return max(1, (int) \App\Models\Setting::get('hotspot_pack_duration_days', 30));
    }

    public function packs(): array
    {
        $packs = [];
        $defaults = [
            'A' => ['slots' => 2, 'price' => 5000, 'label' => 'Standard', 'desc' => 'Idéal pour tester'],
            'B' => ['slots' => 4, 'price' => 7500, 'label' => 'Premium', 'desc' => 'Le meilleur rapport qualité/prix'],
            'C' => ['slots' => 8, 'price' => 12000, 'label' => 'Expert', 'desc' => 'Pour les gros volumes'],
        ];

        foreach (self::PACK_KEYS as $key) {
            $slots = (int) \App\Models\Setting::get("hotspot_pack_{$key}_slots", $defaults[$key]['slots']);
            $price = (int) \App\Models\Setting::get("hotspot_pack_{$key}_price", $defaults[$key]['price']);

            $packs[$key] = [
                'key' => $key,
                'label' => $defaults[$key]['label'],
                'desc' => $defaults[$key]['desc'],
                'slots' => max(1, $slots),
                'price' => max(0, $price),
            ];
        }

        return $packs;
    }

    public function pack(string $key): ?array
    {
        return $this->packs()[$key] ?? null;
    }

    public function usedSlots(Vendeur $vendeur): int
    {
        return $vendeur->hotspots()->count();
    }

    public function paidSlots(Vendeur $vendeur): int
    {
        return (int) HotspotSubscription::where('vendeur_id', $vendeur->id)
            ->where('frozen_at', null)
            ->where('expires_at', '>', now())
            ->sum('slots');
    }

    public function frozenSlots(Vendeur $vendeur): int
    {
        return (int) HotspotSubscription::where('vendeur_id', $vendeur->id)
            ->whereNotNull('frozen_at')
            ->sum('slots');
    }

    public function totalSlots(Vendeur $vendeur): int
    {
        return $this->freeSlots() + $this->paidSlots($vendeur) + $this->frozenSlots($vendeur);
    }

    public function limit(Vendeur $vendeur): int
    {
        return $this->freeSlots() + $this->paidSlots($vendeur);
    }

    public function canCreate(Vendeur $vendeur): bool
    {
        return $this->usedSlots($vendeur) < $this->limit($vendeur);
    }

    public function hasFrozen(Vendeur $vendeur): bool
    {
        return $this->frozenSlots($vendeur) > 0;
    }

    public function remaining(Vendeur $vendeur): int
    {
        return max(0, $this->limit($vendeur) - $this->usedSlots($vendeur));
    }

    public function activeSubscriptions(Vendeur $vendeur)
    {
        return HotspotSubscription::where('vendeur_id', $vendeur->id)
            ->where('frozen_at', null)
            ->where('expires_at', '>', now())
            ->orderByDesc('expires_at')
            ->get();
    }

    public function frozenSubscriptions(Vendeur $vendeur)
    {
        return HotspotSubscription::where('vendeur_id', $vendeur->id)
            ->whereNotNull('frozen_at')
            ->orderByDesc('frozen_at')
            ->get();
    }

    public function freezeExpiredSubscriptions(Vendeur $vendeur): int
    {
        $expired = HotspotSubscription::where('vendeur_id', $vendeur->id)
            ->where('frozen_at', null)
            ->where('expires_at', '<=', now())
            ->get();

        $count = 0;
        foreach ($expired as $sub) {
            $sub->freeze();
            $count++;
        }

        return $count;
    }

    public function renewSubscription(Vendeur $vendeur, string $packKey, string $paymentMethod = 'ligdicash'): HotspotSubscription
    {
        $pack = $this->pack($packKey);
        if (!$pack) {
            throw new \InvalidArgumentException('Pack de hotspot inconnu.');
        }

        $frozen = HotspotSubscription::where('vendeur_id', $vendeur->id)
            ->where('pack_key', $packKey)
            ->whereNotNull('frozen_at')
            ->orderByDesc('frozen_at')
            ->first();

        if ($frozen) {
            $frozen->unfreeze();
            $latest = $frozen->expires_at;
            $frozen->update([
                'slots' => $pack['slots'],
                'montant' => $pack['price'],
                'payment_method' => $paymentMethod,
                'starts_at' => now(),
                'expires_at' => Carbon::parse($latest)->addDays($this->packDurationDays()),
            ]);
            return $frozen->fresh();
        }

        return $this->activatePack($vendeur, $packKey, $paymentMethod);
    }

    public function soldeConsomme(Vendeur $vendeur): float
    {
        return (float) Transaction::where('vendeur_id', $vendeur->id)
            ->where('type', 'pack')
            ->where('payment_method', 'solde')
            ->where('statut', 'completed')
            ->sum('montant');
    }

    public function soldeDisponible(Vendeur $vendeur): float
    {
        $totalRevenus = (float) $vendeur->transactions()->completed()->where('type', 'ticket')->sum('montant');
        $dejaRetire = (float) $vendeur->withdrawals()
            ->whereIn('statut', ['pending', 'approved', 'paid'])
            ->sum('montant_brut');

        return max(0, $totalRevenus - $dejaRetire - $this->soldeConsomme($vendeur));
    }

    public function activatePack(Vendeur $vendeur, string $packKey, string $paymentMethod = 'ligdicash'): HotspotSubscription
    {
        $pack = $this->pack($packKey);
        if (!$pack) {
            throw new \InvalidArgumentException('Pack de hotspot inconnu.');
        }

        $latest = HotspotSubscription::where('vendeur_id', $vendeur->id)
            ->where('expires_at', '>', now())
            ->orderByDesc('expires_at')
            ->value('expires_at');

        $base = $latest ? Carbon::parse($latest) : now();
        $expiresAt = $base->copy()->addDays($this->packDurationDays());

        return HotspotSubscription::create([
            'vendeur_id' => $vendeur->id,
            'pack_key' => $packKey,
            'slots' => $pack['slots'],
            'montant' => $pack['price'],
            'payment_method' => $paymentMethod,
            'starts_at' => now(),
            'expires_at' => $expiresAt,
        ]);
    }
}
