<?php

declare(strict_types=1);

namespace App\Core\ValueObjects;

use InvalidArgumentException;

final readonly class Bandwidth extends ValueObject
{
    public function __construct(
        private int $kilobitsPerSecond,
    ) {
        if ($kilobitsPerSecond <= 0) {
            throw new InvalidArgumentException(
                'Bandwidth must be greater than zero.'
            );
        }
    }

    public static function fromKbps(
        int $kbps,
    ): self {
        return new self($kbps);
    }

    public static function fromMbps(
        int|float $mbps,
    ): self {
        return new self(
            (int) round($mbps * 1000)
        );
    }

    public function kbps(): int
    {
        return $this->kilobitsPerSecond;
    }

    public function mbps(): float
    {
        return $this->kilobitsPerSecond / 1000;
    }

    public function toScalar(): int
    {
        return $this->kilobitsPerSecond;
    }

    public function format(): string
    {
        if ($this->kilobitsPerSecond >= 1000) {
            return rtrim(
                rtrim(
                    number_format(
                        $this->mbps(),
                        2,
                        '.',
                        '',
                    ),
                    '0',
                ),
                '.',
            ) . ' Mbps';
        }

        return $this->kilobitsPerSecond . ' Kbps';
    }
}
