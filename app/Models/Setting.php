<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class Setting extends Model
{
    protected $fillable = [
        'site_name',
        'meta_description',
        'hero_badge',
        'hero_title',
        'hero_subtitle',
        'search_placeholder',
        'footer_copyright',
        'footer_tagline',
        'stats_wilayas_label',
        'stats_offices_label',
        'stats_partners_label',
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

    public function getFormattedHeroTitleAttribute(): string
    {
        $lines = explode("\n", $this->hero_title ?? 'Trouvez le bureau');
        if (count($lines) < 2) {
            return e($lines[0]);
        }
        return e($lines[0]) . ' <br class="hidden sm:block"> <span class="text-transparent bg-clip-text bg-gradient-to-r from-primary to-blue-600">' . e($lines[1]) . '</span>';
    }

    protected static function booted(): void
    {
        static::saved(fn () => Cache::forget('settings'));
    }
}
