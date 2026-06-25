<?php

namespace App\Livewire\Admin;

use App\Models\BugReport;
use Livewire\Component;
use Livewire\WithPagination;

class BugReportManager extends Component
{
    use WithPagination;

    public string $filterStatus = '';
    public string $search = '';

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function updatingFilterStatus(): void
    {
        $this->resetPage();
    }

    public function markResolved(int $id): void
    {
        BugReport::where('id', $id)->update(['status' => 'resolved']);
    }

    public function markSpam(int $id): void
    {
        BugReport::where('id', $id)->update(['status' => 'spam']);
    }

    public function markPending(int $id): void
    {
        BugReport::where('id', $id)->update(['status' => 'pending']);
    }

    public function delete(int $id): void
    {
        BugReport::findOrFail($id)->delete();
    }

    public function getReportsProperty()
    {
        return BugReport::when($this->search, fn($q) => $q->where(function ($q) {
                $q->where('name', 'like', "%{$this->search}%")
                  ->orWhere('email', 'like', "%{$this->search}%")
                  ->orWhere('message', 'like', "%{$this->search}%");
            }))
            ->when($this->filterStatus, fn($q) => $q->where('status', $this->filterStatus))
            ->latest()
            ->paginate(20);
    }

    public function render()
    {
        return view('livewire.admin.bug-report-manager', [
            'reports' => $this->reports,
        ]);
    }
}
