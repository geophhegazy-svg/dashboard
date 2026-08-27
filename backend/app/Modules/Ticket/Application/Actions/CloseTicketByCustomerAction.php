<?php

declare(strict_types=1);

namespace App\Modules\Ticket\Application\Actions;

use App\Modules\Activity\Application\Actions\LogActivityAction;
use App\Modules\Ticket\Domain\Contracts\TicketRepositoryInterface;
use App\Modules\Ticket\Infrastructure\Persistence\Models\Ticket;

final readonly class CloseTicketByCustomerAction
{
    public function __construct(
        private TicketRepositoryInterface $repository,
        private LogActivityAction $logActivity,
    ) {}

    public function execute(Ticket $ticket): Ticket
    {
        if ($ticket->status === 'closed') {
            throw new \RuntimeException('Ticket already closed.');
        }

        $this->repository->update($ticket, [
            'status' => 'closed',
            'closed_at' => now(),
        ]);

        $ticket = $this->repository->fresh($ticket);

        $this->logActivity->execute(
            [
                'tenant_id' => $ticket->tenant_id,
                'module' => 'ticket',
                'action' => 'closed',
            ],
            [
                'user_id' => null,
                'description' => "Customer closed ticket {$ticket->ticket_number}",
                'ip_address' => request()->ip(),
            ],
        );

        return $ticket;
    }
}
