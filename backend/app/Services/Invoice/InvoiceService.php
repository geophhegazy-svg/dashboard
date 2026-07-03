<?php

declare(strict_types=1);

namespace App\Services\Invoice;

use App\Models\Invoice;

class InvoiceService
{
    /**
     * Create Invoice
     */
    public function create(array $data): Invoice
    {
        return Invoice::create($data);
    }

    /**
     * Update Invoice
     */
    public function update(
        Invoice $invoice,
        array $data
    ): Invoice {

        $invoice->update($data);

        return $invoice->fresh([
            'customer',
            'subscription',
        ]);
    }

    /**
     * Delete Invoice
     */
    public function delete(
        Invoice $invoice
    ): bool {

        return (bool) $invoice->delete();
    }
}
