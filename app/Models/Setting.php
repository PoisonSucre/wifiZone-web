<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    public $timestamps = false;

    protected $table = 'settings';

    protected $fillable = [
        'setting_key',
        'setting_value',
        'description',
    ];

    protected function casts(): array
    {
        return [
            'date_modification' => 'datetime',
        ];
    }

    public static function get(string $key, mixed $default = null): mixed
    {
        $setting = static::where('setting_key', $key)->first();

        return $setting?->setting_value ?? $default;
    }

    public static function set(string $key, mixed $value, ?string $description = null): static
    {
        return static::updateOrCreate(
            ['setting_key' => $key],
            [
                'setting_value' => (string) $value,
                'description' => $description,
            ]
        );
    }

    public static function allAsArray(): array
    {
        return static::pluck('setting_value', 'setting_key')->toArray();
    }
}
