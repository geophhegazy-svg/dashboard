<?php

declare(strict_types=1);

namespace App\Modules\Ticket\Infrastructure\Repositories;

use App\Modules\Ticket\Infrastructure\Persistence\Models\Ticket;
use App\Modules\Ticket\Infrastructure\Persistence\Models\TicketReply;
use App\Models\User;
use App\Modules\Ticket\Domain\Contracts\TicketRepositoryInterface;
use Illuminate\Database\Eloquent\Builder;

final class TicketRepository implements TicketRepositoryInterface
{
    public function create(array $attributes): Ticket
    {
        return Ticket::create($attributes);
    }

    public function update(
        Ticket $ticket,
        array $attributes,
    ): bool {
        return $ticket->update($attributes);
    }

    public function save(
        Ticket $ticket,
    ): bool {
        return $ticket->save();
    }

    public function delete(
        Ticket $ticket,
    ): bool {
        return (bool) $ticket->delete();
    }

    public function fresh(
        Ticket $ticket,
        array $relations = [],
    ): Ticket {
        return $ticket->fresh($relations);
    }

    public function createReply(
        array $attributes,
    ): TicketReply {
        return TicketReply::create($attributes);
    }

    public function customerTickets(
        int $customerId,
    ): Builder {
        return Ticket::where(
            'customer_id',
            $customerId,
        );
    }

    public function paginateByCustomerId(
        int $customerId,
        int $perPage = 10,
    ): \Illuminate\Contracts\Pagination\LengthAwarePaginator {
        return Ticket::query()
            ->where('customer_id', $customerId)
            ->latest()
            ->paginate($perPage);
    }

    public function paginateTickets(
        int $perPage = 20,
    ): \Illuminate\Contracts\Pagination\LengthAwarePaginator {
        return Ticket::query()
            ->with('customer')
            ->latest()
            ->paginate($perPage);
    }

    public function findById(
        int $ticketId,
        array $relations = [],
    ): ?Ticket {
        return Ticket::query()
            ->with($relations)
            ->whereKey($ticketId)
            ->first();
    }

    public function findByCustomerIdAndId(
        int $customerId,
        int $ticketId,
        array $relations = [],
    ): ?Ticket {
        return Ticket::query()
            ->with($relations)
            ->where('customer_id', $customerId)
            ->whereKey($ticketId)
            ->first();
    }

    public function adminTickets(): Builder
    {
        return Ticket::query();
    }

    public function assign(
        Ticket $ticket,
        User $user,
    ): bool {
        return $ticket->update([
            'user_id' => $user->id,
        ]);
    }

    public function count(): int
    {
        return Ticket::count();
    }

    public function countByStatus(
        string $status,
    ): int {
        return Ticket::where(
            'status',
            $status,
        )->count();
    }

    public function countHighPriority(): int
    {
        return Ticket::where(
            'priority',
            'high',
        )->count();
    }

    public function countToday(): int
    {
        return Ticket::whereDate(
            'created_at',
            today(),
        )->count();
    }

    public function ticketReplies(
        int $ticketId,
    ): \Illuminate\Support\Collection {
        return TicketReply::with([
            'customer:id,name',
            'user:id,name',
        ])
            ->where('ticket_id', $ticketId)
            ->orderBy('created_at')
            ->get();
    }

    public function freshReply(
        TicketReply $reply,
    ): TicketReply {
        return $reply->fresh();
    }
}
