<?php

declare(strict_types=1);

namespace App\Modules\Ticket\Application\Actions;

use App\Modules\Ticket\Domain\Contracts\TicketRepositoryInterface;

final readonly class GetAdminTicketStatisticsAction
{
    public function __construct(
        private TicketRepositoryInterface $repository,
    ) {}

    public function execute(): array
    {
        return [
            'total'         => $this->repository->count(),
            'open'          => $this->repository->countByStatus('open'),
            'closed'        => $this->repository->countByStatus('closed'),
            'high_priority' => $this->repository->countHighPriority(),
            'today'         => $this->repository->countToday(),
        ];
    }
}
