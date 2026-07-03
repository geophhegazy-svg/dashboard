<?php

declare(strict_types=1);

namespace App\Data\Subscription;

final readonly class UpdateSubscriptionData
{
    public function __construct(
        public int $packageId,
        public ?string $pppoeUsername,
        public string $startDate,
        public string $endDate,
        public string $status,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            packageId: (int) $data['package_id'],
            pppoeUsername: $data['pppoe_username'] ?? null,
            startDate: $data['start_date'],
            endDate: $data['end_date'],
            status: $data['status'],
        );
    }
}
