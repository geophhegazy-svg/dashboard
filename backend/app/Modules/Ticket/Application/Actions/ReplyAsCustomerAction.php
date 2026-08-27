<?php

declare(strict_types=1);

namespace App\Modules\Ticket\Application\Actions;

use App\Modules\Activity\Application\Actions\LogActivityAction;
use App\Modules\Customer\Infrastructure\Persistence\Models\Customer;
use App\Modules\Ticket\Domain\Contracts\TicketRepositoryInterface;
use App\Modules\Ticket\Infrastructure\Persistence\Models\Ticket;
use App\Modules\Ticket\Infrastructure\Persistence\Models\TicketReply;

final readonly class ReplyAsCustomerAction
{
    public function __construct(
        private TicketRepositoryInterface $repository,
        private LogActivityAction $logActivity,
    ) {}

    public function execute(
        Ticket $ticket,
        Customer $customer,
        string $message,
    ): TicketReply {
        if ($ticket->status === 'closed') {
            throw new \RuntimeException('Cannot reply to closed ticket.');
        }

        $reply = $this->repository->createReply([
            'ticket_id' => $ticket->id,
            'customer_id' => $customer->id,
            'user_id' => null,
            'message' => $message,
            'is_staff' => false,
            'sent_at' => now(),
        ]);

        $reply = $this->repository->freshReply($reply);

        $this->repository->update(
            $ticket,
            ['status' => 'in_progress'],
        );

        $this->logActivity->execute(
            [
                'tenant_id' => $ticket->tenant_id,
                'module' => 'ticket',
                'action' => 'reply',
            ],
            [
                'user_id' => null,
                'description' => "Customer replied to ticket {$ticket->ticket_number}",
                'ip_address' => request()->ip(),
            ],
        );

        return $reply;
    }
}
