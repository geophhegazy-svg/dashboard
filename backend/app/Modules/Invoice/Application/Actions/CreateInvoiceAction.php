<?php

declare(strict_types=1);

namespace App\Modules\Invoice\Application\Actions;

use App\Models\Invoice;
use App\Modules\Invoice\Domain\Events\InvoiceCreated;
use App\Modules\Invoice\Domain\Contracts\InvoiceRepositoryInterface;
use App\Modules\Invoice\Application\Services\InvoiceNumberService;

final readonly class CreateInvoiceAction
{
    public function __construct(
        private InvoiceRepositoryInterface $repository,
    ) {}

    public function execute(
        Invoice $invoice,
    ): Invoice {

        $this->repository->save(
            $invoice
        );

        $invoice->invoice_number =
            InvoiceNumberService::generate($invoice);

        $this->repository->save(
            $invoice
        );

        InvoiceCreated::dispatch(
            $invoice
        );

        return $invoice->fresh([
            'customer',
            'subscription',
        ]);
    }
}
