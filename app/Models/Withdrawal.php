<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Withdrawal extends Model
{
    use HasFactory;

    protected $fillable = [
        'vendeur_id',
        'hotspot_id',
        'montant_brut',
        'commission_pct',
        'montant_commission',
        'montant_net',
        'statut',
        'phone_number',
        'operator',
        'note',
        'date_traitement',
        'traite_par',
    ];

    protected function casts(): array
    {
        return [
            'montant_brut' => 'decimal:2',
            'commission_pct' => 'decimal:2',
            'montant_commission' => 'decimal:2',
            'montant_net' => 'decimal:2',
            'date_creation' => 'datetime',
            'date_traitement' => 'datetime',
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

    public function scopePending($query)
    {
        return $query->where('statut', 'pending');
    }

    public function scopeApproved($query)
    {
        return $query->where('statut', 'approved');
    }

    public function scopePaid($query)
    {
        return $query->where('statut', 'paid');
    }

    public function statusLabel(): string
    {
        return match ($this->statut) {
            'pending' => 'En attente',
            'approved' => 'Approuvé',
            'rejected' => 'Rejeté',
            'paid' => 'Payé',
            default => $this->statut,
        };
    }

    public function statusColor(): string
    {
        return match ($this->statut) {
            'pending' => 'warning',
            'approved' => 'info',
            'rejected' => 'error',
            'paid' => 'success',
            default => 'gray',
        };
    }
}
