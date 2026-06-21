<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class Setting extends Model
{
    protected $fillable = [
        'show_code',
        'show_company',
        'show_phone',
        'show_address',
        'show_maps',
        'favicon',
        'logo',
    ];

    protected function casts(): array
    {
        return [
            'show_code' => 'boolean',
            'show_company' => 'boolean',
            'show_phone' => 'boolean',
            'show_address' => 'boolean',
            'show_maps' => 'boolean',
            'favicon' => 'string',
            'logo' => 'string',
        ];
    }

    public static function getSettings(): self
    {
        return Cache::rememberForever('settings', function () {
            return self::first() ?? self::create([]);
        });
    }

    public function getFaviconUrlAttribute(): ?string
    {
        return $this->favicon ? Storage::url($this->favicon) : null;
    }

    public function getLogoUrlAttribute(): ?string
    {
        return $this->logo ? Storage::url($this->logo) : null;
    }

    protected static function booted(): void
    {
        static::saved(fn () => Cache::forget('settings'));
    }
}
