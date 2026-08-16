<?php

declare(strict_types=1);

namespace App\Modules\Invoice\Application\Queries\Handlers;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use App\Modules\Invoice\Application\Queries\PaginateInvoicesQuery;
use App\Modules\Invoice\Domain\Contracts\InvoiceRepositoryInterface;

final readonly class PaginateInvoicesQueryHandler
{
    public function __construct(
        private InvoiceRepositoryInterface $repository,
    ) {}

    public function handle(
        PaginateInvoicesQuery $query,
    ): LengthAwarePaginator {

        return $this->repository->paginate(
            $query->perPage,
        );
    }
}
