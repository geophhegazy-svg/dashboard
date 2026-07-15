<?php

declare(strict_types=1);

namespace App\Modules\Subscription\Domain\Rules;

use App\Modules\Subscription\Domain\Contracts\SubscriptionRuleInterface;
use App\Modules\Subscription\Infrastructure\Persistence\Models\Subscription;

abstract class AbstractSubscriptionRule implements SubscriptionRuleInterface
{
    final public function validate(
        Subscription $subscription
    ): void {

        if (! $this->passes($subscription)) {
            throw new \App\Modules\Subscription\Domain\Exceptions\SubscriptionRuleException(
                $this->message()
            );
        }
    }
}
