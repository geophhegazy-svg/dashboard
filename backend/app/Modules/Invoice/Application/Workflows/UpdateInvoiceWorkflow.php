<?php

declare(strict_types=1);

namespace App\Modules\Invoice\Application\Workflows;

use App\Modules\Invoice\Infrastructure\Persistence\Models\Invoice;
use App\Modules\Invoice\Application\Actions\UpdateInvoiceAction;

final readonly class UpdateInvoiceWorkflow
{
    public function __construct(
        private UpdateInvoiceAction $updateInvoice,
    ) {}

    public function execute(
        Invoice $invoice,
        array $data,
    ): Invoice {

        return $this->updateInvoice->execute(
            $invoice,
            $data,
        );
    }
}
