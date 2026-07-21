<?php

declare(strict_types=1);

namespace App\Core\DTO;

final readonly class RenewalResult
{
    public function __construct(
        public int $processed = 0,
        public int $renewed = 0,
        public int $failed = 0,

        /**
         * @var array<int,string>
         */
        public array $errors = [],
    ) {}

    public function hasFailures(): bool
    {
        return $this->failed > 0;
    }

    public function successRate(): float
    {
        if ($this->processed === 0) {
            return 100.0;
        }

        return round(
            ($this->renewed / $this->processed) * 100,
            2
        );
    }
}
