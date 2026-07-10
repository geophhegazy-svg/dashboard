<?php

declare(strict_types=1);

namespace App\Data\Finance;

final readonly class JournalEntryLineData
{
    public function __construct(
        public int $accountId,
        public float $debit,
        public float $credit,
        public ?string $description = null,
    ) {}
}
