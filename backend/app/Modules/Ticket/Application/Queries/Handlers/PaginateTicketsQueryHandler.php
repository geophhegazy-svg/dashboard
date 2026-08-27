<?php

declare(strict_types=1);

namespace App\Modules\Ticket\Application\Queries\Handlers;

use App\Modules\Ticket\Application\Queries\PaginateTicketsQuery;
use App\Modules\Ticket\Domain\Contracts\TicketRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

final readonly class PaginateTicketsQueryHandler
{
    public function __construct(
        private TicketRepositoryInterface $repository,
    ) {}

    public function handle(
        PaginateTicketsQuery $query,
    ): LengthAwarePaginator {
        return $this->repository->paginateTickets(
            $query->perPage,
        );
    }
}
