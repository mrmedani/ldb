<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
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
        'show_delivery_time',
        'column_order',
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
            'show_delivery_time' => 'boolean',
            'column_order' => 'array',
            'favicon' => 'string',
            'logo' => 'string',
        ];
    }

    public static function getSettings(): self
    {
        return self::first() ?? self::create([]);
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

    public function getOrderedColumnsAttribute(): array
    {
        $allColumns = [
            'wilaya' => ['label' => 'Wilaya', 'sort_field' => 'wilaya_id'],
            'commune' => ['label' => 'Commune'],
            'delivery_time' => ['label' => 'Délai livraison', 'toggle' => 'show_delivery_time'],
            'code' => ['label' => 'Code', 'toggle' => 'show_code'],
            'company' => ['label' => 'Entreprise', 'sort_field' => 'company_name', 'toggle' => 'show_company'],
            'phone' => ['label' => 'Téléphone', 'toggle' => 'show_phone'],
            'address' => ['label' => 'Adresse', 'toggle' => 'show_address'],
            'maps' => ['label' => 'Localisation', 'toggle' => 'show_maps', 'th_class' => 'text-center'],
        ];

        $order = $this->column_order ?? ['wilaya', 'commune', 'delivery_time', 'code', 'company', 'phone', 'address', 'maps'];

        $result = [];
        foreach ($order as $key) {
            if (!isset($allColumns[$key])) continue;
            $col = $allColumns[$key];
            if (isset($col['toggle']) && !$this->{$col['toggle']}) continue;
            $col['key'] = $key;
            $result[] = $col;
        }

        return $result;
    }

    protected static function booted(): void
    {
    }
}
