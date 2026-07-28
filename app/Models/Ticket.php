<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Ticket extends Model
{
    use HasFactory;

    protected $table = 'ticket';

    protected $fillable = [
        'vendeur_id',
        'hotspot_id',
        'user',
        'password',
        'forfait',
        'montant',
        'token',
        'status',
        'source',
    ];

    protected $hidden = [
        'password',
        'token',
    ];

    protected function casts(): array
    {
        return [
            'montant' => 'integer',
            'date_creation' => 'datetime',
        ];
    }

    public function vendeur(): BelongsTo
    {
        return $this->belongsTo(Vendeur::class);
    }

    public function hotspot(): BelongsTo
    {
        return $this->belongsTo(Hotspot::class);
    }

    public function scopeAvailable($query)
    {
        return $query->where('status', 'disponible');
    }

    public function scopeSold($query)
    {
        return $query->where('status', 'vendu');
    }

    public function isAvailable(): bool
    {
        return $this->status === 'disponible';
    }

    public function isSold(): bool
    {
        return $this->status === 'vendu';
    }
}
