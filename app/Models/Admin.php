<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Admin extends Authenticatable
{
    use Notifiable;

    protected $table = 'admins';

    protected $fillable = [
        'nom',
        'prenom',
        'email',
        'password',
        'password_reset_token',
        'password_reset_token_expires_at',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'password' => 'hashed',
            'password_reset_token_expires_at' => 'datetime',
        ];
    }

    public function fullName(): string
    {
        return "{$this->prenom} {$this->nom}";
    }
}
