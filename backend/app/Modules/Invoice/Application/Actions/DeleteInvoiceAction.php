<?php

declare(strict_types=1);

namespace App\Modules\Invoice\Application\Actions;

use App\Modules\Invoice\Infrastructure\Persistence\Models\Invoice;
use App\Modules\Invoice\Domain\Contracts\InvoiceRepositoryInterface;

final readonly class DeleteInvoiceAction
{
    public function __construct(
        private InvoiceRepositoryInterface $repository,
    ) {}

    public function execute(
        Invoice $invoice,
    ): bool {

        return $this->repository->delete(
            $invoice,
        );
    }
}
