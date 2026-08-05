<?php

declare(strict_types=1);

namespace App\Modules\Ticket\Application\Actions;

use App\Modules\Customer\Infrastructure\Persistence\Models\Customer;
use App\Modules\Ticket\Domain\Contracts\TicketRepositoryInterface;

final readonly class GetCustomerTicketStatisticsAction
{
    public function __construct(
        private TicketRepositoryInterface $repository,
    ) {}

    public function execute(
        Customer $customer,
    ): array {

        $tickets = $this->repository->customerTickets(
            $customer->id,
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
