<?php

declare(strict_types=1);

namespace App\Modules\Ticket\Application\Actions;

use App\Modules\Activity\Application\Actions\LogActivityAction;
use App\Modules\Ticket\Domain\Contracts\TicketRepositoryInterface;
use App\Modules\Ticket\Infrastructure\Persistence\Models\Ticket;

final readonly class CreateAdminTicketAction
{
    public function __construct(
        private TicketRepositoryInterface $repository,
        private LogActivityAction $logActivity,
    ) {}

    public function execute(array $data, ?int $actingUserId): Ticket
    {
        $ticket = $this->repository->create($data);

        $this->logActivity->execute(
            [
                'tenant_id' => $ticket->tenant_id,
                'module' => 'ticket',
                'action' => 'created',
            ],
            [
                'user_id' => $actingUserId,
                'description' => "Created ticket {$ticket->ticket_number}",
                'ip_address' => request()->ip(),
            ],
        );

        return $ticket;
    }
}
