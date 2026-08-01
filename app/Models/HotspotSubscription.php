<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class HotspotSubscription extends Model
{
    protected $fillable = [
        'vendeur_id',
        'pack_key',
        'slots',
        'montant',
        'payment_method',
        'starts_at',
        'expires_at',
        'frozen_at',
    ];

    protected function casts(): array
    {
        return [
            'slots' => 'integer',
            'montant' => 'integer',
            'starts_at' => 'datetime',
            'expires_at' => 'datetime',
            'frozen_at' => 'datetime',
        ];
    }

    public function vendeur(): BelongsTo
    {
        return $this->belongsTo(Vendeur::class);
    }

    public function isActive(): bool
    {
        return $this->frozen_at === null && $this->expires_at !== null && $this->expires_at->isFuture();
    }

    public function isFrozen(): bool
    {
        return $this->frozen_at !== null;
    }

    public function freeze(): void
    {
        $this->frozen_at = now();
        $this->save();
    }

    public function unfreeze(): void
    {
        $this->frozen_at = null;
        $this->save();
    }
}
