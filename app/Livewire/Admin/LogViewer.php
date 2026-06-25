<?php

namespace App\Livewire\Admin;

use App\Models\ActivityLog;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Schema;
use Livewire\Component;
use Livewire\WithPagination;

class LogViewer extends Component
{
    use WithPagination;

    public string $search = '';
    public string $filterAction = '';
    public string $filterType = '';
    public int $total = 0;

    public function mount(): void
    {
        $this->total = $this->safeCount();
    }

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function updatingFilterAction(): void
    {
        $this->resetPage();
    }

    public function updatingFilterType(): void
    {
        $this->resetPage();
    }

    public function getLogsProperty()
    {
        if (!Schema::hasTable('activity_log')) {
            return new LengthAwarePaginator([], 0, 30);
        }

        return ActivityLog::with('user')
            ->when($this->search, fn($q) => $q->where('description', 'like', "%{$this->search}%"))
            ->when($this->filterAction, fn($q) => $q->where('action', $this->filterAction))
            ->when($this->filterType, fn($q) => $q->where('subject_type', $this->filterType))
            ->latest()
            ->paginate(30);
    }

    public function render()
    {
        return view('livewire.admin.log-viewer', [
            'logs' => $this->logs,
            'actionTypes' => $this->safePluck('action'),
            'subjectTypes' => $this->safePluck('subject_type'),
        ]);
    }

    private function safeCount(): int
    {
        if (!Schema::hasTable('activity_log')) return 0;
        return ActivityLog::count();
    }

    private function safePluck(string $column)
    {
        if (!Schema::hasTable('activity_log')) return collect();
        return ActivityLog::select($column)->distinct()->pluck($column);
    }
}
