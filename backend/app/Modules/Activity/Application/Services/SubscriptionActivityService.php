<?php

declare(strict_types=1);

namespace App\Modules\Activity\Application\Services;

use App\Modules\Activity\Infrastructure\Persistence\Models\ActivityLog;
use App\Modules\Activity\Application\Workflows\CreateActivityLogWorkflow;
use App\Modules\Subscription\Infrastructure\Persistence\Models\Subscription;

final readonly class SubscriptionActivityService
{
    public function __construct(
        private CreateActivityLogWorkflow $workflow,
    ) {}

    public function log(
        Subscription $subscription,
        string $action,
        ?int $userId = null,
        ?string $ipAddress = null
    ): ActivityLog {
        return $this->workflow->execute([
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
