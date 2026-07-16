<?php

declare(strict_types=1);

namespace App\Core\ValueObjects;

use Stringable;

abstract readonly class ValueObject implements Stringable
{
    final public function equals(
        self $other,
    ): bool {
        return static::class === $other::class
            && $this->toScalar() === $other->toScalar();
    }

    final public function __toString(): string
    {
        return (string) $this->toScalar();
    }

    abstract public function toScalar(): mixed;
}
