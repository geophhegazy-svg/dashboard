<?php

declare(strict_types=1);

namespace App\Services\Subscription;

use App\Modules\Subscription\Application\Commands\SuspendSubscriptionAction;
use App\Modules\Subscription\Infrastructure\Persistence\Models\Subscription;

class SubscriptionSuspensionService
{
    public function __construct(
        private readonly SuspendSubscriptionAction $action,
    ) {}

    public function suspend(
        Subscription $subscription
    ): bool {

        return $this->action
            ->execute($subscription);
    }
}
