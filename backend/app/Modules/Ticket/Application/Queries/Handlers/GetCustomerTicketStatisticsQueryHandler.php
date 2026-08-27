<?php

declare(strict_types=1);

namespace App\Modules\Ticket\Application\Queries\Handlers;

use App\Modules\Ticket\Application\Queries\GetCustomerTicketStatisticsQuery;
use App\Modules\Ticket\Domain\Contracts\TicketRepositoryInterface;

final readonly class GetCustomerTicketStatisticsQueryHandler
{
    public function __construct(
        private TicketRepositoryInterface $repository,
    ) {}

    public function handle(
        GetCustomerTicketStatisticsQuery $query,
    ): array {
        $tickets = $this->repository->customerTickets(
            $query->customerId,
        );

        $lastTicket = (clone $tickets)
            ->latest()
            ->first();

        return [
            'statistics' => [
                'total' => (clone $tickets)->count(),
                'open' => (clone $tickets)
                    ->where('status', 'open')
                    ->count(),
                'closed' => (clone $tickets)
                    ->where('status', 'closed')
                    ->count(),
                'high_priority' => (clone $tickets)
                    ->where('priority', 'high')
                    ->count(),
            ],
            'last_ticket' => $lastTicket,
        ];
    }
}
