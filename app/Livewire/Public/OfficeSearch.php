<?php

namespace App\Livewire\Public;

use App\Models\Office;
use App\Models\Setting;
use App\Models\Wilaya;
use Livewire\Component;

class OfficeSearch extends Component
{
    public string $search = '';
    public string $sortField = 'display_order';
    public string $sortDirection = 'asc';

    protected $queryString = [
        'search' => ['except' => ''],
    ];

    public function sortBy(string $field): void
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'asc';
        }
    }

    public function getOfficesProperty()
    {
        return Office::with(['wilaya', 'commune'])
            ->visible()
            ->when($this->search, fn($q) => $q->where(function ($q) {
                $q->where('company_name', 'like', "%{$this->search}%")
                  ->orWhere('phone', 'like', "%{$this->search}%")
                  ->orWhereHas('wilaya', fn($q) => $q->where('name', 'like', "%{$this->search}%"))
                  ->orWhereHas('commune', fn($q) => $q->where('name', 'like', "%{$this->search}%"));
            }))
            ->orderBy($this->sortField, $this->sortDirection)
            ->get();
    }

    public function getSettingsProperty()
    {
        return Setting::getSettings();
    }

    public function getStatsProperty(): array
    {
        $groups = [];
        $names = Office::visible()->pluck('company_name');

        foreach ($names as $name) {
            $normalized = trim(strtolower($name));
            $firstWord = strtok($normalized, " \t\n\r\0\x0B");
            $matched = false;

            if (strlen($firstWord ?? '') >= 3) {
                foreach ($groups as $i => $group) {
                    $gFirst = strtok($group[0], " \t\n\r\0\x0B");
                    if (strlen($gFirst ?? '') < 3) continue;
                    $dist = levenshtein($firstWord, $gFirst);
                    $maxLen = max(strlen($firstWord), strlen($gFirst));
                    if ($maxLen > 0 && ($dist / $maxLen) < 0.35) {
                        $groups[$i][] = $normalized;
                        $matched = true;
                        break;
                    }
                }
            }

            if (!$matched) {
                $groups[] = [$normalized];
            }
        }

        return [
            'wilayas' => Wilaya::count(),
            'offices' => Office::visible()->count(),
            'partners' => count($groups),
        ];
    }

    public function render()
    {
        return view('livewire.public.office-search', [
            'offices' => $this->offices,
            'settings' => $this->settings,
            'stats' => $this->stats,
        ]);
    }
}
