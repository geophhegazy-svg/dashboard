<?php

declare(strict_types=1);

namespace App\Modules\Invoice\Application\Workflows;

use App\Modules\Invoice\Infrastructure\Persistence\Models\Invoice;
use App\Modules\Invoice\Application\Actions\DeleteInvoiceAction;

final readonly class DeleteInvoiceWorkflow
{
    public function __construct(
        private DeleteInvoiceAction $deleteInvoice,
    ) {}

    public function execute(
        Invoice $invoice,
    ): bool {

        return $this->deleteInvoice->execute(
            $invoice,
        );
    }
}
