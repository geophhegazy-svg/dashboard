<?php

declare(strict_types=1);

namespace App\Modules\Invoice\Application\Services;

use App\Models\Invoice;
use App\Modules\Invoice\Application\Actions\CreateInvoiceAction;
use App\Modules\Invoice\Application\Actions\UpdateInvoiceAction;
use App\Modules\Invoice\Application\Actions\DeleteInvoiceAction;

final readonly class InvoiceService
{
    public function __construct(
        private CreateInvoiceAction $createInvoice,
        private UpdateInvoiceAction $updateInvoice,
        private DeleteInvoiceAction $deleteInvoice,
    ) {}

    public function create(
        array $data,
    ): Invoice {

        $invoice = new Invoice($data);

        return $this->createInvoice->execute(
            $invoice,
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
