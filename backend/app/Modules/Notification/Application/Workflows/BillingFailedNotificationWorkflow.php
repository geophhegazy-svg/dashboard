<?php

declare(strict_types=1);

namespace App\Modules\Notification\Application\Workflows;

use App\Modules\Notification\Infrastructure\Persistence\Models\Notification;
use App\Modules\Notification\Application\Actions\BillingFailedNotificationAction;
use App\Modules\Subscription\Infrastructure\Persistence\Models\Subscription;

final readonly class BillingFailedNotificationWorkflow
{
    public function __construct(
        private BillingFailedNotificationAction $action,
    ) {}

    public function execute(
        Subscription $subscription,
    ): Notification {

        return $this->action->execute(
            $subscription,
        );
    }
}
