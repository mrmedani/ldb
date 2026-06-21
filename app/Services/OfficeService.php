<?php

namespace App\Services;

use App\Models\Office;
use Illuminate\Support\Collection;

class OfficeService
{
    public function reorder(Office $office, string $direction): void
    {
        $currentOrder = $office->display_order;
        $neighbor = $direction === 'up'
            ? Office::where('display_order', '<', $currentOrder)->orderBy('display_order', 'desc')->first()
            : Office::where('display_order', '>', $currentOrder)->orderBy('display_order')->first();

        if ($neighbor) {
            $temp = $office->display_order;
            $office->update(['display_order' => $neighbor->display_order]);
            $neighbor->update(['display_order' => $temp]);
        }
    }

    public function bulkDelete(array $ids): void
    {
        Office::whereIn('id', $ids)->delete();
    }

    public function bulkToggleVisibility(array $ids, bool $visible): void
    {
        Office::whereIn('id', $ids)->update(['is_visible' => $visible]);
    }

    public function getFilteredData(?string $search, ?string $wilayaId, ?string $visibility): Collection
    {
        return Office::with('wilaya')
            ->when($search, fn($q) => $q->where(function ($q) use ($search) {
                $q->where('company_name', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%")
                  ->orWhere('address', 'like', "%{$search}%")
                  ->orWhereHas('wilaya', fn($q) => $q->where('name', 'like', "%{$search}%"));
            }))
            ->when($wilayaId, fn($q) => $q->where('wilaya_id', $wilayaId))
            ->when($visibility !== null, fn($q) => $q->where('is_visible', $visibility === 'visible'))
            ->ordered()
            ->get();
    }

    public function updateOrder(array $items): void
    {
        foreach ($items as $index => $id) {
            Office::where('id', $id)->update(['display_order' => $index + 1]);
        }
    }
}
