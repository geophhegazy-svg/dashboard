<?php

declare(strict_types=1);

namespace App\Modules\Ticket\Application\Queries\Handlers;

use App\Modules\Ticket\Application\Queries\GetAdminTicketStatisticsQuery;
use App\Modules\Ticket\Domain\Contracts\TicketRepositoryInterface;

final readonly class GetAdminTicketStatisticsQueryHandler
{
    public function __construct(
        private TicketRepositoryInterface $repository,
    ) {}

    public function handle(
        GetAdminTicketStatisticsQuery $query,
    ): array {
        return [
            'total' => $this->repository->count(),
            'open' => $this->repository->countByStatus('open'),
            'closed' => $this->repository->countByStatus('closed'),
            'high_priority' => $this->repository->countHighPriority(),
            'today' => $this->repository->countToday(),
        ];
    }
}
