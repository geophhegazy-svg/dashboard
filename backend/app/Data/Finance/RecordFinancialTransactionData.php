<?php

declare(strict_types=1);

namespace App\Data\Finance;

final readonly class RecordFinancialTransactionData
{
    public function __construct(
        public string $type,
        public float $amount,
        public ?int $customerId = null,
        public ?int $subscriptionId = null,
        public ?int $invoiceId = null,
        public ?int $paymentId = null,
        public ?int $walletTransactionId = null,
        public ?string $description = null,
        public array $metadata = [],
    ) {}
}
