<?php

declare(strict_types=1);

namespace App\Data\Subscription;

final readonly class RenewSubscriptionData
{
    public function __construct(
        public int $days,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            days: (int) ($data['days'] ?? 30),
        );
    }
}
