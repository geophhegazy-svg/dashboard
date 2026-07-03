<?php

declare(strict_types=1);

namespace App\Data\Subscription;

final readonly class CreateSubscriptionData
{
    public function __construct(
        public int $customerId,
        public int $packageId,
        public ?string $pppoeUsername,
        public string $startDate,
        public string $endDate,
        public string $status,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            customerId: (int) $data['customer_id'],
            packageId: (int) $data['package_id'],
            pppoeUsername: $data['pppoe_username'] ?? null,
            startDate: $data['start_date'],
            endDate: $data['end_date'],
            status: $data['status'],
        );
    }
}
