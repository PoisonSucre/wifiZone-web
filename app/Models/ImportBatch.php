<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ImportBatch extends Model
{
    use HasFactory;

    protected $table = 'import_batches';

    protected $fillable = [
        'vendeur_id',
        'hotspot_id',
        'filename',
        'format_file',
        'total_tickets',
        'statut',
    ];

    protected function casts(): array
    {
        return [
            'total_tickets' => 'integer',
            'imported_at' => 'datetime',
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
}
