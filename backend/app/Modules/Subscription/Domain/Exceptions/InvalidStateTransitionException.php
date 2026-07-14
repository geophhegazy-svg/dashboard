<?php

declare(strict_types=1);

namespace App\Modules\Subscription\Domain\Exceptions;

use App\Modules\Subscription\Domain\Enums\SubscriptionStatus;
use RuntimeException;

class InvalidStateTransitionException extends RuntimeException
{
    /**
     * Create exception from invalid state transition.
     */
    public static function fromStates(
        SubscriptionStatus $from,
        SubscriptionStatus $to
    ): self {
        return new self(
            sprintf(
                'Invalid subscription state transition from [%s] to [%s].',
                $from->value,
                $to->value
            )
        );
    }
}
