<?php

declare(strict_types=1);

namespace App\Application\Subscription\Validators;

use App\Application\Shared\Contracts\ValidatorInterface;
use App\Models\Subscription;
use InvalidArgumentException;

class ActivateSubscriptionValidator implements ValidatorInterface
{
    public function validate(
        mixed ...$arguments
    ): void {

        /** @var Subscription|null $subscription */
        $subscription = $arguments[0] ?? null;

        if (! $subscription instanceof Subscription) {
            throw new InvalidArgumentException(
                'A valid subscription instance is required.'
            );
        }

        if (! $subscription->exists) {
            throw new InvalidArgumentException(
                'Subscription does not exist.'
            );
        }

        if (! $subscription->customer) {
            throw new InvalidArgumentException(
                'Subscription has no customer.'
            );
        }

        if (! $subscription->package) {
            throw new InvalidArgumentException(
                'Subscription has no package.'
            );
        }
    }
}
