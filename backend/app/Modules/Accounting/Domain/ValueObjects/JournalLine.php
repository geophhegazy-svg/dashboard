<?php

declare(strict_types=1);

namespace App\Modules\Accounting\Domain\ValueObjects;

use App\Modules\Accounting\Domain\Enums\AccountingAccount;

final readonly class JournalLine
{
    public function __construct(
        public AccountingAccount $account,
        public float $debit,
        public float $credit,
        public ?string $description = null,
    ) {}
}
