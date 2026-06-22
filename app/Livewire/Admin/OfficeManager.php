<?php

namespace App\Livewire\Admin;

use App\Models\Office;
use App\Models\Wilaya;
use App\Services\OfficeService;
use Livewire\Component;
use Livewire\WithPagination;

class OfficeManager extends Component
{
    use WithPagination;

    public string $search = '';
    public string $sortField = 'display_order';
    public string $sortDirection = 'asc';
    public ?string $filterWilaya = null;
    public ?string $filterVisibility = null;
    public array $selected = [];
    public bool $selectAll = false;

    protected $queryString = [
        'search' => ['except' => ''],
        'sortField' => ['except' => 'display_order'],
        'sortDirection' => ['except' => 'asc'],
        'filterWilaya' => ['except' => ''],
        'filterVisibility' => ['except' => ''],
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
    }

    public function toggleVisibility(int $id): void
    {
        $office = Office::findOrFail($id);
        $office->update(['is_visible' => !$office->is_visible]);
    }

    public function moveUp(int $id): void
    {
        app(OfficeService::class)->reorder(Office::findOrFail($id), 'up');
    }

    public function moveDown(int $id): void
    {
        app(OfficeService::class)->reorder(Office::findOrFail($id), 'down');
    }

    public function deleteOffice(int $id): void
    {
        Office::findOrFail($id)->delete();
        $this->dispatch('notify', message: 'Bureau supprimé avec succès.', type: 'success');
    }

    public function deleteSelected(): void
    {
        app(OfficeService::class)->bulkDelete($this->selected);
        $this->selected = [];
        $this->selectAll = false;
        $this->dispatch('notify', message: 'Bureaux supprimés avec succès.', type: 'success');
    }

    public function toggleSelectedVisibility(): void
    {
        $office = Office::find($this->selected[0] ?? 0);
        if ($office) {
            $visible = !$office->is_visible;
            app(OfficeService::class)->bulkToggleVisibility($this->selected, $visible);
            $this->dispatch('notify', message: 'Visibilité mise à jour.', type: 'success');
        }
    }

    public function updatedSelectAll(bool $value): void
    {
        $this->selected = $value ? $this->offices->pluck('id')->map(fn($id) => (string) $id)->toArray() : [];
    }

    public function exportExcel(): void
    {
        $this->dispatch('notify', message: 'Préparation de l\'export Excel...', type: 'info');
    }

    public function exportPdf(): void
    {
        $this->dispatch('notify', message: 'Préparation de l\'export PDF...', type: 'info');
    }

    public function updateOrder(array $items): void
    {
        app(OfficeService::class)->updateOrder($items);
        $this->dispatch('notify', message: 'Ordre mis à jour.', type: 'success');
    }

    public function getOfficesProperty()
    {
        return Office::with(['wilaya', 'commune'])
            ->when($this->search, fn($q) => $q->where(function ($q) {
                $q->where('company_name', 'like', "%{$this->search}%")
                  ->orWhere('phone', 'like', "%{$this->search}%")
                  ->orWhereHas('wilaya', fn($q) => $q->where('name', 'like', "%{$this->search}%"))
                  ->orWhereHas('commune', fn($q) => $q->where('name', 'like', "%{$this->search}%"));
            }))
            ->when($this->filterWilaya, fn($q) => $q->where('wilaya_id', $this->filterWilaya))
            ->when($this->filterVisibility === 'visible', fn($q) => $q->where('is_visible', true))
            ->when($this->filterVisibility === 'hidden', fn($q) => $q->where('is_visible', false))
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate(15);
    }

    public function getWilayasProperty()
    {
        return Wilaya::orderBy('name')->get();
    }

    public function render()
    {
        return view('livewire.admin.office-manager', [
            'offices' => $this->offices,
            'wilayas' => $this->wilayas,
        ]);
    }
}
