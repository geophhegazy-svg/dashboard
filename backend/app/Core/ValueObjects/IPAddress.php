<?php

declare(strict_types=1);

namespace App\Core\ValueObjects;

use InvalidArgumentException;

final readonly class IPAddress extends ValueObject
{
    public function __construct(
        private string $value,
    ) {
        if (! filter_var($value, FILTER_VALIDATE_IP)) {
            throw new InvalidArgumentException(
                sprintf(
                    '"%s" is not a valid IP address.',
                    $value,
                )
            );
        }
    }

    public static function make(
        string $value,
    ): self {
        return new self($value);
    }

    public function value(): string
    {
        return $this->value;
    }

    public function toScalar(): string
    {
        return $this->value;
    }

    public function isIpv4(): bool
    {
        return filter_var(
            $this->value,
            FILTER_VALIDATE_IP,
            FILTER_FLAG_IPV4,
        ) !== false;
    }

    public function isIpv6(): bool
    {
        return filter_var(
            $this->value,
            FILTER_VALIDATE_IP,
            FILTER_FLAG_IPV6,
        ) !== false;
    }
}
