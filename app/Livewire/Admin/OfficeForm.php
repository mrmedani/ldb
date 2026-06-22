<?php

namespace App\Livewire\Admin;

use App\Models\Office;
use App\Models\Wilaya;
use App\Http\Requests\StoreOfficeRequest;
use App\Http\Requests\UpdateOfficeRequest;
use Livewire\Component;

class OfficeForm extends Component
{
    public ?int $officeId = null;
    public string $wilaya_id = '';
    public string $wilaya_code = '';
    public string $commune_id = '';
    public string $company_name = '';
    public string $phone = '';
    public string $phone_secondary = '';
    public string $address = '';
    public string $google_maps = '';
    public int $display_order = 0;
    public bool $is_visible = true;

    public bool $editing = false;

    public function mount(?int $id = null): void
    {
        if ($id) {
            $this->editing = true;
            $this->officeId = $id;
            $office = Office::with('wilaya')->findOrFail($id);
            $this->wilaya_id = (string) $office->wilaya_id;
            $this->wilaya_code = $office->wilaya->code;
            $this->commune_id = (string) ($office->commune_id ?? '');
            $this->company_name = $office->company_name;
            $this->phone = $office->phone;
            $this->phone_secondary = $office->phone_secondary ?? '';
            $this->address = $office->address;
            $this->google_maps = $office->google_maps ?? '';
            $this->display_order = $office->display_order;
            $this->is_visible = $office->is_visible;
        }
    }

    public function updatedWilayaId(string $value): void
    {
        if ($value) {
            $wilaya = Wilaya::find($value);
            $this->wilaya_code = $wilaya?->code ?? '';
            $this->display_order = (int) ($wilaya?->code ?? 0);
        } else {
            $this->wilaya_code = '';
            $this->display_order = 0;
        }
    }

    public function save(): void
    {
        $data = $this->validate([
            'wilaya_id' => ['required', 'exists:wilayas,id'],
            'commune_id' => ['nullable', 'exists:communes,id'],
            'company_name' => ['required', 'string', 'max:200'],
            'phone' => ['required', 'string', 'max:50'],
            'phone_secondary' => ['nullable', 'string', 'max:50'],
            'address' => ['required', 'string'],
            'google_maps' => ['nullable', 'string', 'max:2048'],
            'display_order' => ['nullable', 'integer', 'min:0'],
            'is_visible' => ['boolean'],
        ]);

        $data['google_maps'] = $this->google_maps ?: null;

        if ($this->editing) {
            Office::findOrFail($this->officeId)->update($data);
            $this->dispatch('notify', message: 'Bureau mis à jour avec succès.', type: 'success');
        } else {
            Office::create($data);
            $this->dispatch('notify', message: 'Bureau créé avec succès.', type: 'success');
            $this->reset(['wilaya_id', 'wilaya_code', 'commune_id', 'company_name', 'phone', 'phone_secondary', 'address', 'google_maps', 'display_order']);
        }
    }

    public function getWilayasProperty()
    {
        return Wilaya::orderBy('name')->get();
    }

    public function getCommunesProperty()
    {
        if (!$this->wilaya_id) return collect();
        return \App\Models\Commune::where('wilaya_id', $this->wilaya_id)->orderBy('name')->get();
    }

    public function render()
    {
        return view('livewire.admin.office-form', [
            'wilayas' => $this->wilayas,
            'communes' => $this->communes,
        ]);
    }
}
