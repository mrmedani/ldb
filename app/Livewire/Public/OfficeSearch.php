<?php

namespace App\Livewire\Public;

use App\Models\Office;
use App\Models\Setting;
use App\Models\Wilaya;
use Illuminate\Support\Facades\Cache;
use Livewire\Component;
use Livewire\WithPagination;

class OfficeSearch extends Component
{
    use WithPagination;

    public string $search = '';
    public string $sortField = 'wilaya_id';
    public string $sortDirection = 'asc';
    public int $perPage = 50;

    protected $queryString = [
        'search' => ['except' => ''],
        'sortField' => ['except' => 'wilaya_id'],
        'sortDirection' => ['except' => 'asc'],
    ];

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function sortBy(string $field): void
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'asc';
        }
        $this->resetPage();
    }

    public function getSettingsProperty()
    {
        return Setting::getSettings();
    }

    public function getStatsProperty(): array
    {
        return Cache::remember('public_stats', 3600, function () {
            $groups = [];
            $names = Office::visible()->pluck('company_name');

            foreach ($names as $name) {
                $normalized = preg_replace('/\s+/', ' ', trim(strtolower($name)));
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
        });
    }

    public function render()
    {
        $offices = Office::with(['wilaya', 'commune'])
            ->visible()
            ->when($this->search, fn($q) => $q->where(function ($q) {
                $q->where('company_name', 'like', "%{$this->search}%")
                  ->orWhere('phone', 'like', "%{$this->search}%")
                  ->orWhereHas('wilaya', fn($q) => $q->where('name', 'like', "%{$this->search}%"))
                  ->orWhereHas('commune', fn($q) => $q->where('name', 'like', "%{$this->search}%"));
            }))
            ->orderBy($this->sortField, $this->sortDirection)
            ->orderBy('display_order')
            ->paginate($this->perPage);

        return view('livewire.public.office-search', [
            'offices' => $offices,
            'settings' => $this->settings,
            'stats' => $this->stats,
        ]);
    }
}
