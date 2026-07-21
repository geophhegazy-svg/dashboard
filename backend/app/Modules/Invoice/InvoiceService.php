<?php

declare(strict_types=1);

namespace App\Modules\Invoice;

use App\Events\InvoiceCreated;
use App\Models\Invoice;

class InvoiceService
{
    public function create(
        array $data
    ): Invoice {

        $invoice = Invoice::create(
            $data
        );

        $invoice->update([

            'invoice_number' => InvoiceNumberService::generate(
                $invoice
            ),

        ]);

        InvoiceCreated::dispatch(
            $invoice
        );

        return $invoice->fresh();
    }


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


    public function delete(
        Invoice $invoice
    ): bool {

        return (bool) $invoice->delete();
    }
}
