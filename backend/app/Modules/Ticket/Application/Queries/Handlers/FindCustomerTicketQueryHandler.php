<?php

declare(strict_types=1);

namespace App\Modules\Ticket\Application\Queries\Handlers;

use App\Modules\Ticket\Application\Queries\FindCustomerTicketQuery;
use App\Modules\Ticket\Domain\Contracts\TicketRepositoryInterface;
use App\Modules\Ticket\Infrastructure\Persistence\Models\Ticket;

final readonly class FindCustomerTicketQueryHandler
{
    public function __construct(
        private TicketRepositoryInterface $repository,
    ) {}

    public function handle(
        FindCustomerTicketQuery $query,
    ): ?Ticket {
        return $this->repository->findByCustomerIdAndId(
            $query->customerId,
            $query->ticketId,
            $query->relations,
        );
    }
}
