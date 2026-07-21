<?php

declare(strict_types=1);

namespace App\Modules\Activity\Application\Services;

use App\Models\ActivityLog;

final class ActivityLogService
{
    public static function log(
        int $tenantId,
        ?int $userId,
        string $module,
        string $action,
        string $description
    ): void {

        ActivityLog::firstOrCreate(

            [
                'tenant_id' => $tenantId,
                'module'    => $module,
                'action'    => $action,
            ],

            [
                'user_id'     => $userId,
                'description' => $description,
                'ip_address'  => request()->ip(),
            ]

        );
    }
}
