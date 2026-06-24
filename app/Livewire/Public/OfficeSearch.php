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
        return [
            'wilayas' => Wilaya::count(),
            'offices' => Office::visible()->count(),
            'partners' => Office::visible()->selectRaw('COUNT(DISTINCT LOWER(company_name)) as cnt')->value('cnt'),
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
