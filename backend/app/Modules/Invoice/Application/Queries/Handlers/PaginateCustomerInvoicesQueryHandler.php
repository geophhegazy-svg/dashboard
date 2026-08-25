<?php

declare(strict_types=1);

namespace App\Modules\Invoice\Application\Queries\Handlers;

use App\Modules\Invoice\Application\Queries\PaginateCustomerInvoicesQuery;
use App\Modules\Invoice\Domain\Contracts\InvoiceRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

final readonly class PaginateCustomerInvoicesQueryHandler
{
    public function __construct(
        private InvoiceRepositoryInterface $repository,
    ) {}

    public function handle(
        PaginateCustomerInvoicesQuery $query,
    ): LengthAwarePaginator {
        return $this->repository->paginateByCustomerId(
            $query->customerId,
            $query->perPage,
        );
    }
}
