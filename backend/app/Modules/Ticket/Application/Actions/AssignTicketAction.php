<?php

declare(strict_types=1);

namespace App\Modules\Ticket\Application\Actions;

use App\Models\User;
use App\Modules\Activity\Application\Actions\LogActivityAction;
use Illuminate\Auth\Access\AuthorizationException;
use App\Modules\Ticket\Domain\Contracts\TicketRepositoryInterface;
use App\Modules\Ticket\Infrastructure\Persistence\Models\Ticket;

final readonly class AssignTicketAction
{
    public function __construct(
        private TicketRepositoryInterface $repository,
        private LogActivityAction $logActivity,
    ) {}

    public function execute(
        Ticket $ticket,
        User $user,
        ?int $actingUserId,
    ): Ticket {
        $actor = $actingUserId !== null
            ? User::find($actingUserId)
            : null;

        if (
            $actor !== null
            && !$actor->hasRole('Super Admin')
            && $ticket->tenant_id !== $user->tenant_id
        ) {
            throw new AuthorizationException(
                'Cannot assign a ticket to a user from another tenant.'
            );
        }

        $this->repository->assign($ticket, $user);

        $ticket = $this->repository->fresh($ticket);

        $this->logActivity->execute(
            [
                'tenant_id' => $ticket->tenant_id,
                'module' => 'ticket',
                'action' => 'assigned',
            ],
            [
                'user_id' => $actingUserId,
                'description' => "Assigned {$ticket->ticket_number} to {$user->name}",
                'ip_address' => request()->ip(),
            ],
        );

        return $ticket;
    }
}
