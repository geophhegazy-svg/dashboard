<?php

declare(strict_types=1);

namespace App\Modules\Invoice\Application\Queries\Handlers;

use App\Modules\Invoice\Application\Queries\FindCustomerInvoiceQuery;
use App\Modules\Invoice\Domain\Contracts\InvoiceRepositoryInterface;
use App\Modules\Invoice\Infrastructure\Persistence\Models\Invoice;

final readonly class FindCustomerInvoiceQueryHandler
{
    public function __construct(
        private InvoiceRepositoryInterface $repository,
    ) {}

    public function handle(
        FindCustomerInvoiceQuery $query,
    ): ?Invoice {
        return $this->repository->findByCustomerIdAndId(
            $query->customerId,
            $query->invoiceId,
        );
    }
}
