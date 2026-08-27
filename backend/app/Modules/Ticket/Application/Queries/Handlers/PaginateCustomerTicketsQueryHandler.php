<?php

declare(strict_types=1);

namespace App\Modules\Ticket\Application\Queries\Handlers;

use App\Modules\Ticket\Application\Queries\PaginateCustomerTicketsQuery;
use App\Modules\Ticket\Domain\Contracts\TicketRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

final readonly class PaginateCustomerTicketsQueryHandler
{
    public function __construct(
        private TicketRepositoryInterface $repository,
    ) {}

    public function handle(
        PaginateCustomerTicketsQuery $query,
    ): LengthAwarePaginator {
        return $this->repository->paginateByCustomerId(
            $query->customerId,
            $query->perPage,
        );
    }
}
