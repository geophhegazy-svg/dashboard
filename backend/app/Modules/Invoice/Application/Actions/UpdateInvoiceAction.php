<?php

declare(strict_types=1);

namespace App\Modules\Invoice\Application\Actions;

use App\Modules\Invoice\Infrastructure\Persistence\Models\Invoice;
use App\Modules\Invoice\Domain\Contracts\InvoiceRepositoryInterface;

final readonly class UpdateInvoiceAction
{
    public function __construct(
        private InvoiceRepositoryInterface $repository,
    ) {}

    public function execute(
        Invoice $invoice,
        array $data,
    ): Invoice {

        $this->repository->update(
            $invoice,
            $data,
        );

        return $this->repository->fresh(
            $invoice,
            [
                'customer',
                'subscription',
            ],
        );
    }
}
