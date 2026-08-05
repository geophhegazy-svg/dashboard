<?php

declare(strict_types=1);

namespace App\Modules\Invoice\Application\Services;

use App\Modules\Invoice\Infrastructure\Persistence\Models\Invoice;
use App\Modules\Invoice\Application\Workflows\CreateInvoiceWorkflow;
use App\Modules\Invoice\Application\Workflows\UpdateInvoiceWorkflow;
use App\Modules\Invoice\Application\Workflows\DeleteInvoiceWorkflow;

final readonly class InvoiceService
{
    public function __construct(
        private CreateInvoiceWorkflow $createInvoice,
        private UpdateInvoiceWorkflow $updateInvoice,
        private DeleteInvoiceWorkflow $deleteInvoice,
    ) {}

    public function create(
        array $data,
    ): Invoice {

        return $this->createInvoice->execute(
            $data,
        );
    }

    public function update(
        Invoice $invoice,
        array $data,
    ): Invoice {

        return $this->updateInvoice->execute(
            $invoice,
            $data,
        );
    }

    public function delete(
        Invoice $invoice,
    ): bool {

        return $this->deleteInvoice->execute(
            $invoice,
        );
    }
}
