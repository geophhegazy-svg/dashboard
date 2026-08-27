<?php

declare(strict_types=1);

namespace App\Modules\Ticket\Application\Actions;

use App\Modules\Activity\Application\Actions\LogActivityAction;
use App\Modules\Ticket\Domain\Contracts\TicketRepositoryInterface;
use App\Modules\Ticket\Infrastructure\Persistence\Models\Ticket;

final readonly class DeleteTicketAction
{
    public function __construct(
        private TicketRepositoryInterface $repository,
        private LogActivityAction $logActivity,
    ) {}

    public function execute(
        Ticket $ticket,
        ?int $actingUserId,
    ): void {
        $this->logActivity->execute(
            [
                'tenant_id' => $ticket->tenant_id,
                'module' => 'ticket',
                'action' => 'deleted',
            ],
            [
                'user_id' => $actingUserId,
                'description' => "Deleted ticket {$ticket->ticket_number}",
                'ip_address' => request()->ip(),
            ],
        );

        $this->repository->delete($ticket);
    }
}
