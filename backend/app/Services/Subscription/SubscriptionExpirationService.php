<?php

declare(strict_types=1);

namespace App\Services\Subscription;

use App\Actions\Subscription\ExpireSubscriptionAction;
use App\Models\Subscription;

class SubscriptionExpirationService
{
    public function __construct(
        private readonly ExpireSubscriptionAction $action,
    ) {}

    public function expire(
        Subscription $subscription
    ): bool {

        return $this->action
            ->execute($subscription);
    }
}
