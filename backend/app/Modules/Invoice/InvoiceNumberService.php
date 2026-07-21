<?php

declare(strict_types=1);

namespace App\Modules\Invoice;

use App\Models\Invoice;

class InvoiceNumberService
{
    /**
     * Generate invoice number from persisted invoice ID.
     */
    public static function generate(Invoice $invoice): string
    {
        return 'INV-' . str_pad(
            (string) $invoice->id,
            6,
            '0',
            STR_PAD_LEFT
        );
    }
}
