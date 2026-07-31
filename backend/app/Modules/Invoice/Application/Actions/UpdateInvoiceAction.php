<?php

declare(strict_types=1);

namespace App\Modules\Invoice\Application\Actions;

use App\Models\Invoice;

final class UpdateInvoiceAction
{
    public function execute(
        Invoice $invoice,
        array $data,
    ): Invoice {

        $invoice->update($data);

        return $invoice->fresh([
            'customer',
            'subscription',
        ]);
    }
}
