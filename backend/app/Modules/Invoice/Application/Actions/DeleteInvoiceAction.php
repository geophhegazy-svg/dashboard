<?php

declare(strict_types=1);

namespace App\Modules\Invoice\Application\Actions;

use App\Models\Invoice;

final class DeleteInvoiceAction
{
    public function execute(
        Invoice $invoice,
    ): bool {

        return (bool) $invoice->delete();
    }
}
