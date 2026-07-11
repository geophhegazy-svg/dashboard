<?php

declare(strict_types=1);

namespace App\Services\Activity;

use App\Models\ActivityLog;

class ActivityLogService
{
    public static function log(
        int $tenantId,
        ?int $userId,
        string $module,
        string $action,
        string $description
    ): void {
        ActivityLog::create([
            'tenant_id'   => $tenantId,
            'user_id'     => $userId,
            'module'      => $module,
            'action'      => $action,
            'description' => $description,
            'ip_address'  => request()->ip(),
        ]);
    }
}
