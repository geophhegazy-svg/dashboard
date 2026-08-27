<?php

declare(strict_types=1);

namespace App\Modules\Ticket\Application\Actions;

use App\Modules\Activity\Application\Actions\LogActivityAction;
use App\Modules\Customer\Infrastructure\Persistence\Models\Customer;
use App\Modules\Ticket\Domain\Contracts\TicketRepositoryInterface;
use App\Modules\Ticket\Infrastructure\Persistence\Models\Ticket;

final readonly class CreateCustomerTicketAction
{
    public function __construct(
        private TicketRepositoryInterface $repository,
        private LogActivityAction $logActivity,
    ) {}

    public function execute(Customer $customer, array $data): Ticket
    {
        $ticket = $this->repository->create([
            'tenant_id' => $customer->tenant_id,
            'customer_id' => $customer->id,
            'user_id' => null,
            'ticket_number' => 'TKT-' . now()->format('YmdHis') . '-' . $customer->id,
            'subject' => $data['subject'],
            'description' => $data['description'],
            'priority' => $data['priority'] ?? 'medium',
            'status' => 'open',
            'opened_at' => now(),
            'closed_at' => null,
            'notes' => null,
        ]);

        $this->logActivity->execute(
            [
                'tenant_id' => $ticket->tenant_id,
                'module' => 'ticket',
                'action' => 'created',
            ],
            [
                'user_id' => null,
                'description' => "Customer {$customer->name} created ticket {$ticket->ticket_number}",
                'ip_address' => request()->ip(),
            ],
        );

        return $ticket;
    }
}
