<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Vendeur extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'vendeurs';

    protected $fillable = [
        'nom',
        'prenom',
        'email',
        'email_verified_at',
        'is_admin',
        'telephone',
        'password',
        'adresse',
        'ville',
        'statut',
        'commission_pct',
        'couleur',
        'couleur_top',
        'nom_portail',
        'logo',
        'message_bienvenue',
        'card_number',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'commission_pct' => 'decimal:2',
            'date_inscription' => 'datetime',
            'last_login' => 'datetime',
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function hotspots(): HasMany
    {
        return $this->hasMany(Hotspot::class);
    }

    public function forfaits(): HasMany
    {
        return $this->hasMany(Forfait::class)->orderBy('ordre');
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

    public function fullName(): string
    {
        return "{$this->prenom} {$this->nom}";
    }

    public function shopUrl(): string
    {
        return route('shop', $this->id);
    }

    public function scopeActive($query)
    {
        return $query->where('statut', 'actif');
    }

    public function scopePending($query)
    {
        return $query->where('statut', 'en_attente');
    }

    public static function generateCardNumber(): string
    {
        do {
            $number = substr(str_shuffle("0123456789"), 0, 4) . '-' . 
                      substr(str_shuffle("0123456789"), 0, 4) . '-' . 
                      substr(str_shuffle("0123456789"), 0, 4) . '-' . 
                      substr(str_shuffle("0123456789"), 0, 4);
        } while (self::where('card_number', $number)->exists());

        return $number;
    }
}
