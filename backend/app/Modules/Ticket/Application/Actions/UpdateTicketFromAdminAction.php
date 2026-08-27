<?php

declare(strict_types=1);

namespace App\Modules\Ticket\Application\Actions;

use App\Modules\Activity\Application\Actions\LogActivityAction;
use App\Modules\Ticket\Domain\Contracts\TicketRepositoryInterface;
use App\Modules\Ticket\Infrastructure\Persistence\Models\Ticket;

final readonly class UpdateTicketFromAdminAction
{
    public function __construct(
        private TicketRepositoryInterface $repository,
        private LogActivityAction $logActivity,
    ) {}

    public function execute(
        Ticket $ticket,
        array $data,
        ?int $actingUserId,
    ): Ticket {
        $this->repository->update($ticket, $data);

        $ticket = $this->repository->fresh($ticket);

        $this->logActivity->execute(
            [
                'tenant_id' => $ticket->tenant_id,
                'module' => 'ticket',
                'action' => 'updated',
            ],
            [
                'user_id' => $actingUserId,
                'description' => "Updated ticket {$ticket->ticket_number}",
                'ip_address' => request()->ip(),
            ],
        );

        return $ticket;
    }
}
