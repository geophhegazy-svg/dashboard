<?php

declare(strict_types=1);

namespace App\Modules\Ticket\Application\Queries\Handlers;

use App\Modules\Ticket\Application\Queries\GetTicketStatusMetricsQuery;
use App\Modules\Ticket\Domain\Contracts\TicketRepositoryInterface;

final readonly class GetTicketStatusMetricsQueryHandler
{
    public function __construct(
        private TicketRepositoryInterface $repository,
    ) {}

    public function handle(
        GetTicketStatusMetricsQuery $query,
    ): array {
        return [
            'open' => $this->repository->countByStatus('open'),
            'in_progress' => $this->repository->countByStatus('in_progress'),
            'resolved' => $this->repository->countByStatus('resolved'),
            'closed' => $this->repository->countByStatus('closed'),
        ];
    }
}
