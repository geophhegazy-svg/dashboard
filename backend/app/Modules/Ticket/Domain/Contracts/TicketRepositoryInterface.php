<?php

declare(strict_types=1);

namespace App\Modules\Ticket\Domain\Contracts;

use App\Modules\Ticket\Infrastructure\Persistence\Models\Ticket;
use App\Modules\Ticket\Infrastructure\Persistence\Models\TicketReply;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;

interface TicketRepositoryInterface
{
    public function create(array $attributes): Ticket;

    public function update(
        Ticket $ticket,
        array $attributes,
    ): bool;

    public function save(
        Ticket $ticket,
    ): bool;

    public function delete(
        Ticket $ticket,
    ): bool;

    public function fresh(
        Ticket $ticket,
        array $relations = [],
    ): Ticket;

    public function createReply(
        array $attributes,
    ): TicketReply;

    public function customerTickets(
        int $customerId,
    ): Builder;

    public function adminTickets(): Builder;

    public function assign(
        Ticket $ticket,
        User $user,
    ): bool;

    public function freshReply(
        TicketReply $reply,
    ): TicketReply;

    public function count(): int;

    public function countByStatus(
        string $status,
    ): int;

    public function countHighPriority(): int;

    public function countToday(): int;
}
