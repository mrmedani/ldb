<?php

namespace App\Exports;

use App\Models\Office;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class OfficesExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection()
    {
        return Office::with('wilaya')->ordered()->get();
    }

    public function headings(): array
    {
        return [
            'Ordre',
            'Wilaya',
            'Commune',
            'Code Wilaya',
            'Entreprise',
            'Téléphone',
            'Adresse',
            'Google Maps',
            'Visible',
        ];
    }

    public function map($office): array
    {
        return [
            $office->display_order,
            $office->wilaya->name,
            $office->commune?->name ?? '',
            $office->wilaya->code,
            $office->company_name,
            $office->phone,
            $office->address,
            $office->google_maps,
            $office->is_visible ? 'Oui' : 'Non',
        ];
    }
}
