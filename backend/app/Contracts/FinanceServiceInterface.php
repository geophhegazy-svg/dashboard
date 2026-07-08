<?php

declare(strict_types=1);

namespace App\Contracts;

use App\Data\Finance\FinanceTransactionData;

interface FinanceServiceInterface
{
    /**
     * Record a financial transaction.
     *
     * Version 1.0 acts as the unified entry point for all
     * financial operations. Persistence and accounting
     * integration will be added in future versions.
     */
    public function record(FinanceTransactionData $transaction): void;
}
