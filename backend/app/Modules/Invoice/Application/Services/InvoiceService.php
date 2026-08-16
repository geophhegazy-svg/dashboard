<?php

declare(strict_types=1);

namespace App\Modules\Invoice\Application\Services;

use App\Modules\Invoice\Infrastructure\Persistence\Models\Invoice;
use App\Modules\Invoice\Application\Actions\CreateInvoiceAction;
use App\Modules\Invoice\Application\Actions\UpdateInvoiceAction;
use App\Modules\Invoice\Application\Actions\DeleteInvoiceAction;
use App\Modules\Invoice\Application\Contracts\InvoiceServiceInterface;

final readonly class InvoiceService implements InvoiceServiceInterface
{
    public function __construct(
        private CreateInvoiceAction $createInvoice,
        private UpdateInvoiceAction $updateInvoice,
        private DeleteInvoiceAction $deleteInvoice,
    ) {}

    public function create(array $data): Invoice
    {
        $invoice = Invoice::where(
            'subscription_id',
            $data['subscription_id']
        )->first();

        if ($invoice) {
            return $invoice;
        }

        return $this->createInvoice->execute($data);
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
