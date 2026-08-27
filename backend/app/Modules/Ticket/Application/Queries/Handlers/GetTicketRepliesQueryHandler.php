<?php

declare(strict_types=1);

namespace App\Modules\Ticket\Application\Queries\Handlers;

use App\Modules\Ticket\Application\Queries\GetTicketRepliesQuery;
use App\Modules\Ticket\Domain\Contracts\TicketRepositoryInterface;
use Illuminate\Support\Collection;

final readonly class GetTicketRepliesQueryHandler
{
    public function __construct(
        private TicketRepositoryInterface $repository,
    ) {}

    public function handle(
        GetTicketRepliesQuery $query,
    ): Collection {
        return $this->repository->ticketReplies(
            $query->ticketId,
        );
    }
}
