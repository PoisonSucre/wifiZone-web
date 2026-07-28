<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Transaction extends Model
{
    use HasFactory;

    protected $table = 'transactions';

    protected $fillable = [
        'vendeur_id',
        'hotspot_id',
        'token',
        'transaction_id',
        'montant',
        'statut',
        'ticket_id',
        'phone_number',
        'verification_status',
        'commission',
    ];

    protected function casts(): array
    {
        return [
            'montant' => 'integer',
            'commission' => 'decimal:2',
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

    public function ticket(): BelongsTo
    {
        return $this->belongsTo(Ticket::class);
    }

    public function scopeCompleted($query)
    {
        return $query->where('statut', 'completed');
    }

    public function scopePending($query)
    {
        return $query->where('statut', 'pending');
    }

    public function isCompleted(): bool
    {
        return $this->statut === 'completed';
    }
}
