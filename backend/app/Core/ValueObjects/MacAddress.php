<?php

declare(strict_types=1);

namespace App\Core\ValueObjects;

use InvalidArgumentException;

final readonly class MacAddress extends ValueObject
{
    private string $value;

    public function __construct(
        string $value,
    ) {
        $normalized = strtoupper(
            str_replace('-', ':', $value)
        );

        if (
            ! preg_match(
                '/^([0-9A-F]{2}:){5}[0-9A-F]{2}$/',
                $normalized,
            )
        ) {
            throw new InvalidArgumentException(
                sprintf(
                    '"%s" is not a valid MAC address.',
                    $value,
                )
            );
        }

        $this->value = $normalized;
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

    public function isBroadcast(): bool
    {
        return $this->value === 'FF:FF:FF:FF:FF:FF';
    }

    public function isMulticast(): bool
    {
        return (hexdec(substr($this->value, 0, 2)) & 1) === 1;
    }

    public function isUnicast(): bool
    {
        return ! $this->isMulticast();
    }
}
