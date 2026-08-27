<?php

declare(strict_types=1);

namespace App\Modules\Ticket\Application\Actions;

use App\Modules\Activity\Application\Actions\LogActivityAction;
use App\Modules\Ticket\Domain\Contracts\TicketRepositoryInterface;
use App\Modules\Ticket\Infrastructure\Persistence\Models\Ticket;

final readonly class ChangeTicketStatusAction
{
    public function __construct(
        private TicketRepositoryInterface $repository,
        private LogActivityAction $logActivity,
    ) {}

    public function execute(
        Ticket $ticket,
        string $status,
        ?int $actingUserId,
    ): Ticket {
        $attributes = [
            'status' => $status,
        ];

        if ($status === 'closed') {
            $attributes['closed_at'] = now();
        }

        $this->repository->update($ticket, $attributes);

        $ticket = $this->repository->fresh($ticket);

        $this->logActivity->execute(
            [
                'tenant_id' => $ticket->tenant_id,
                'module' => 'ticket',
                'action' => 'status',
            ],
            [
                'user_id' => $actingUserId,
                'description' => "Changed {$ticket->ticket_number} status to {$ticket->status}",
                'ip_address' => request()->ip(),
            ],
        );

        return $ticket;
    }
}
