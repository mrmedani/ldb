<?php

namespace App\Services;

use App\Models\ActivityLog;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Schema;

class ActivityLogger
{
    public static function log(
        string $action,
        string $subjectType,
        int|string|null $subjectId = null,
        ?string $description = null,
        mixed $oldValues = null,
        mixed $newValues = null,
    ): ?ActivityLog {
        if (!Schema::hasTable('activity_log')) {
            return null;
        }

        try {
            return ActivityLog::create([
                'user_id'    => auth()->id(),
                'action'     => $action,
                'subject_type' => $subjectType,
                'subject_id' => $subjectId,
                'description' => $description ?? "{$action} {$subjectType}#{$subjectId}",
                'old_values' => $oldValues ? (is_array($oldValues) ? $oldValues : ['value' => $oldValues]) : null,
                'new_values' => $newValues ? (is_array($newValues) ? $newValues : ['value' => $newValues]) : null,
                'ip_address' => Request::ip(),
            ]);
        } catch (\Exception $e) {
            return null;
        }
    }
}
