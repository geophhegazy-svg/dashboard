<?php

namespace App\Services;

use App\Models\Invoice;

class InvoiceNumberService
{
    public static function generate(): string
    {
        $lastInvoice = Invoice::latest('id')->first();

        $next = $lastInvoice
            ? $lastInvoice->id + 1
            : 1;

        return 'INV-' . str_pad(
            $next,
            6,
            '0',
            STR_PAD_LEFT
        );
    }
}
