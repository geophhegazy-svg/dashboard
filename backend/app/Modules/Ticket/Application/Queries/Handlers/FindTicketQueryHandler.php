<?php

declare(strict_types=1);

namespace App\Modules\Ticket\Application\Queries\Handlers;

use App\Modules\Ticket\Application\Queries\FindTicketQuery;
use App\Modules\Ticket\Domain\Contracts\TicketRepositoryInterface;
use App\Modules\Ticket\Infrastructure\Persistence\Models\Ticket;

final readonly class FindTicketQueryHandler
{
    public function __construct(
        private TicketRepositoryInterface $repository,
    ) {}

    public function handle(
        FindTicketQuery $query,
    ): ?Ticket {
        return $this->repository->findById(
            $query->ticketId,
            $query->relations,
        );
    }
}
