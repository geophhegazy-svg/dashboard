<?php

declare(strict_types=1);

namespace App\Modules\Invoice\Application\Actions;

use App\Modules\Invoice\Infrastructure\Persistence\Models\Invoice;
use App\Modules\Invoice\Domain\Contracts\InvoiceRepositoryInterface;

final readonly class SettleInvoiceAction
{
    public function __construct(
        private InvoiceRepositoryInterface $repository,
    ) {}

    public function execute(
        Invoice $invoice,
        float $totalPaid,
    ): Invoice {
        if (
            $invoice->status === 'paid'
            || $totalPaid < $invoice->amount
        ) {
            return $invoice;
        }

        $this->repository->update(
            $invoice,
            [
                'status' => 'paid',
                'paid_at' => now(),
            ],
        );

        return $this->repository->fresh($invoice);
    }
}
