<?php

declare(strict_types=1);

namespace App\Data\Finance;

use App\Enums\FinancialTransactionType;

final readonly class FinanceTransactionData
{
    public function __construct(
        public int $tenantId,
        public ?int $customerId,
        public FinancialTransactionType $type,
        public string $amount,
        public ?string $referenceType,
        public ?int $referenceId,
        public ?string $description,
        public string $transactionDate,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            tenantId: (int) $data['tenant_id'],
            customerId: isset($data['customer_id'])
                ? (int) $data['customer_id']
                : null,

            type: $data['type'] instanceof FinancialTransactionType
                ? $data['type']
                : FinancialTransactionType::from($data['type']),

            amount: (string) $data['amount'],

            referenceType: $data['reference_type'] ?? null,

            referenceId: isset($data['reference_id'])
                ? (int) $data['reference_id']
                : null,

            description: $data['description'] ?? null,

            transactionDate: $data['transaction_date']
                ?? now()->toDateTimeString(),
        );
    }
}
