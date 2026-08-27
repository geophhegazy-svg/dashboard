<?php

declare(strict_types=1);

namespace App\Modules\Ticket\Application\Actions;

use App\Modules\Activity\Application\Actions\LogActivityAction;
use App\Modules\Ticket\Domain\Contracts\TicketRepositoryInterface;
use App\Modules\Ticket\Infrastructure\Persistence\Models\Ticket;
use App\Modules\Ticket\Infrastructure\Persistence\Models\TicketReply;

final readonly class ReplyAsStaffAction
{
    public function __construct(
        private TicketRepositoryInterface $repository,
        private LogActivityAction $logActivity,
    ) {}

    public function execute(
        Ticket $ticket,
        int $userId,
        string $message,
    ): TicketReply {
        if ($ticket->status === 'closed') {
            throw new \RuntimeException('Ticket is already closed.');
        }

        $reply = $this->repository->createReply([
            'ticket_id' => $ticket->id,
            'customer_id' => null,
            'user_id' => $userId,
            'message' => $message,
            'is_staff' => true,
            'sent_at' => now(),
        ]);

        $reply = $this->repository->freshReply($reply);

        $this->logActivity->execute(
            [
                'tenant_id' => $ticket->tenant_id,
                'module' => 'ticket',
                'action' => 'reply',
            ],
            [
                'user_id' => $userId,
                'description' => "Staff replied to {$ticket->ticket_number}",
                'ip_address' => request()->ip(),
            ],
        );

        return $reply;
    }
}
