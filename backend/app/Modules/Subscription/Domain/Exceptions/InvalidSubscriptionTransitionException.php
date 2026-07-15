<?php

declare(strict_types=1);

namespace App\Modules\Subscription\Domain\Exceptions;

use RuntimeException;

final class InvalidSubscriptionTransitionException extends RuntimeException
{
    public static function fromTransition(
        string $from,
        string $transition
    ): self {
        return new self(
            sprintf(
                'Cannot execute "%s" while subscription is "%s".',
                $transition,
                $from
            )
        );
    }
}
