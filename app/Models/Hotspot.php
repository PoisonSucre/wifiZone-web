<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Hotspot extends Model
{
    protected $fillable = [
        'vendeur_id',
        'name',
        'description',
        'statut',
    ];

    protected $casts = [
        'statut' => 'string',
    ];

    public function vendeur(): BelongsTo
    {
        return $this->belongsTo(Vendeur::class);
    }

    public function forfaits(): HasMany
    {
        return $this->hasMany(Forfait::class);
    }

    public function tickets(): HasMany
    {
        return $this->hasMany(Ticket::class);
    }

    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class);
    }

    public function withdrawals(): HasMany
    {
        return $this->hasMany(Withdrawal::class);
    }

    public function importBatches(): HasMany
    {
        return $this->hasMany(ImportBatch::class);
    }
}
