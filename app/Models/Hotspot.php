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
        'slot_type',
        'couleur',
        'couleur_top',
        'nom_portail',
        'message_bienvenue',
        'logo',
        'mikrotik_url',
    ];

    protected $casts = [
        'statut' => 'string',
        'slot_type' => 'string',
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
}
