<?php

declare(strict_types=1);

namespace App\Modules\Activity\Application\Services;

use App\Models\ActivityLog;
use App\Modules\Subscription\Infrastructure\Persistence\Models\Subscription;

final class SubscriptionActivityService
{
    public function log(
        Subscription $subscription,
        string $action,
        ?int $userId = null,
        ?string $ipAddress = null
    ): ActivityLog {
        return ActivityLog::create([
            'tenant_id'   => $subscription->tenant_id,
            'user_id'     => $userId,
            'module'      => 'subscription',
            'action'      => $action,
            'description' => sprintf(
                'Subscription #%d (%s) %s successfully.',
                $subscription->id,
                $subscription->pppoe_username,
                $action
            ),
            'ip_address'  => $ipAddress,
        ]);
    }
}
