<?php

declare(strict_types=1);

namespace App\Services\Subscription;

use App\Actions\Subscription\ActivateSubscriptionAction;
use App\Actions\Subscription\ExpireSubscriptionAction;
use App\Actions\Subscription\RenewSubscriptionAction;
use App\Actions\Subscription\RestoreSubscriptionAction;
use App\Actions\Subscription\SuspendSubscriptionAction;
use App\Models\Subscription;

class SubscriptionLifecycleService
{
    public function __construct(
        private readonly ActivateSubscriptionAction $activateAction,
        private readonly SuspendSubscriptionAction $suspendAction,
        private readonly ExpireSubscriptionAction $expireAction,
        private readonly RenewSubscriptionAction $renewAction,
        private readonly RestoreSubscriptionAction $restoreAction,
    ) {}

    public function activate(
        Subscription $subscription
    ): bool {
        return $this->activateAction->execute($subscription);
    }

    public function suspend(
        Subscription $subscription
    ): bool {
        return $this->suspendAction->execute($subscription);
    }

    public function expire(
        Subscription $subscription
    ): bool {
        return $this->expireAction->execute($subscription);
    }

    public function renew(
        Subscription $subscription,
        int $days = 30
    ): bool {
        return $this->renewAction->execute(
            $subscription,
            $days
        );
    }

    public function restore(
        Subscription $subscription
    ): bool {
        return $this->restoreAction->execute($subscription);
    }
}
