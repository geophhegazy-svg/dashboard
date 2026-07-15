<?php

declare(strict_types=1);

namespace App\Modules\Subscription\Domain\Rules;

use App\Modules\Subscription\Domain\Enums\SubscriptionStatus;
use App\Modules\Subscription\Infrastructure\Persistence\Models\Subscription;

final class CanActivateSubscriptionRule extends AbstractSubscriptionRule
{
    public function passes(
        Subscription $subscription
    ): bool {

        return $subscription->status !== SubscriptionStatus::ACTIVE;
    }

    public function message(): string
    {
        return 'Subscription is already active.';
    }
}
