<?php

declare(strict_types=1);

namespace App\Services\Finance;

use App\Data\Finance\FinanceTransactionData;

class FinanceService
{
    /**
     * Record a financial transaction.
     *
     * This is currently a placeholder service that acts as the
     * single entry point for all financial operations.
     *
     * Future versions will persist transactions, dispatch events,
     * and integrate with the Accounting Engine.
     */
    public function record(FinanceTransactionData $transaction): void
    {
        // Intentionally left blank.
        //
        // Version 1.0 does not persist financial transactions.
        // The purpose of this service is to provide a stable API
        // for future Accounting integration.
    }
}
