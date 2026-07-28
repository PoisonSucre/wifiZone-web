<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Forfait extends Model
{
    use HasFactory;

    protected $table = 'vendor_forfaits';

    protected $fillable = [
        'vendeur_id',
        'hotspot_id',
        'label',
        'montant',
        'duree_minutes',
        'actif',
        'ordre',
    ];

    protected function casts(): array
    {
        return [
            'montant' => 'integer',
            'duree_minutes' => 'integer',
            'actif' => 'boolean',
            'ordre' => 'integer',
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

    public function scopeActive($query)
    {
        return $query->where('actif', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('ordre');
    }

    public function formattedDuration(): string
    {
        $hours = intdiv($this->duree_minutes, 60);
        $minutes = $this->duree_minutes % 60;

        if ($hours > 0 && $minutes > 0) {
            return "{$hours}h{$minutes}min";
        } elseif ($hours > 0) {
            return "{$hours}h";
        } else {
            return "{$minutes}min";
        }
    }
}
