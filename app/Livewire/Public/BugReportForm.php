<?php

namespace App\Livewire\Public;

use App\Models\BugReport;
use Livewire\Component;

class BugReportForm extends Component
{
    public bool $show = false;
    public string $name = '';
    public string $email = '';
    public string $message = '';
    public bool $sent = false;

    protected function rules(): array
    {
        return [
            'name' => 'required|string|max:100',
            'email' => 'required|email|max:100',
            'message' => 'required|string|min:10|max:2000',
        ];
    }

    public function submit(): void
    {
        $this->validate();

        BugReport::create([
            'name' => $this->name,
            'email' => $this->email,
            'message' => $this->message,
            'url' => url()->previous(),
        ]);

        $this->reset(['name', 'email', 'message']);
        $this->sent = true;

        $this->dispatch('icon-refresh');
    }

    public function resetForm(): void
    {
        $this->reset(['name', 'email', 'message', 'sent']);
        $this->show = false;

        $this->dispatch('icon-refresh');
    }

    public function updatedShow(): void
    {
        $this->dispatch('icon-refresh');
    }

    public function render()
    {
        return view('livewire.public.bug-report-form');
    }
}
