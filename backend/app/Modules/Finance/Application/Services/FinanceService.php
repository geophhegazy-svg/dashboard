<?php

declare(strict_types=1);

namespace App\Modules\Finance\Application\Services;

use App\Modules\Finance\Domain\Contracts\FinanceServiceInterface;
use App\Data\Finance\FinanceTransactionData;


class FinanceService implements FinanceServiceInterface
{
    /**
     * Record a financial transaction.
     *
     * Version 1.0 is intentionally lightweight.
     * It provides a stable entry point for all
     * financial operations without persisting data.
     *
     * Future versions will:
     * - Store financial transactions
     * - Dispatch domain events
     * - Generate journal entries
     * - Integrate with the Accounting Engine
     */
    public function record(FinanceTransactionData $transaction): void
    {
        // Intentionally left blank.
    }
}
