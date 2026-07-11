<?php

declare(strict_types=1);

namespace App\Services\Ticket;

use App\Models\Customer;
use App\Models\Ticket;
use App\Models\TicketReply;
use App\Models\User;
use App\Services\Activity\ActivityLogService;
use Illuminate\Support\Facades\DB;

class TicketService
{
    /**
     * إنشاء تذكرة جديدة من لوحة تحكم الموظفين (Admin).
     */
    public function createFromAdmin(array $data, ?int $actingUserId): Ticket
    {
        $ticket = Ticket::create($data);

        ActivityLogService::log(
            tenantId: $ticket->tenant_id,
            userId: $actingUserId,
            module: 'ticket',
            action: 'created',
            description: "Created ticket {$ticket->ticket_number}"
        );

        return $ticket;
    }

    /**
     * إنشاء تذكرة جديدة من بوابة العميل.
     */
    public function createFromCustomer(Customer $customer, array $data): Ticket
    {
        $ticket = Ticket::create([

            'tenant_id'     => $customer->tenant_id,
            'customer_id'   => $customer->id,
            'user_id'       => null,

            'ticket_number' => 'TKT-' . now()->format('YmdHis') . '-' . $customer->id,

            'subject'       => $data['subject'],
            'description'   => $data['description'],
            'priority'      => $data['priority'] ?? 'medium',
            'status'        => 'open',
            'opened_at'     => now(),
            'closed_at'     => null,
            'notes'         => null,
        ]);

        ActivityLogService::log(
            tenantId: $customer->tenant_id,
            userId: null,
            module: 'ticket',
            action: 'created',
            description: "Customer {$customer->name} created ticket {$ticket->ticket_number}"
        );

        return $ticket;
    }

    /**
     * تحديث بيانات تذكرة من لوحة تحكم الموظفين.
     */
    public function updateFromAdmin(Ticket $ticket, array $data, ?int $actingUserId): Ticket
    {
        $ticket->update($data);

        ActivityLogService::log(
            tenantId: $ticket->tenant_id,
            userId: $actingUserId,
            module: 'ticket',
            action: 'updated',
            description: "Updated ticket {$ticket->ticket_number}"
        );

        return $ticket->fresh();
    }

    /**
     * حذف تذكرة (Admin فقط).
     */
    public function delete(Ticket $ticket, ?int $actingUserId): void
    {
        ActivityLogService::log(
            tenantId: $ticket->tenant_id,
            userId: $actingUserId,
            module: 'ticket',
            action: 'deleted',
            description: "Deleted ticket {$ticket->ticket_number}"
        );

        $ticket->delete();
    }

    /**
     * رد الموظف (Staff) على تذكرة.
     *
     * @throws \RuntimeException لو التذكرة مقفولة بالفعل.
     */
    public function replyAsStaff(Ticket $ticket, int $userId, string $message): TicketReply
    {
        if ($ticket->status === 'closed') {
            throw new \RuntimeException('Ticket is already closed.');
        }

        $reply = TicketReply::create([
            'ticket_id'   => $ticket->id,
            'customer_id' => null,
            'user_id'     => $userId,
            'message'     => $message,
            'is_staff'    => true,
            'sent_at'     => now(),
        ]);

        ActivityLogService::log(
            tenantId: $ticket->tenant_id,
            userId: $userId,
            module: 'ticket',
            action: 'reply',
            description: "Staff replied to {$ticket->ticket_number}"
        );

        return $reply;
    }

    /**
     * رد العميل على تذكرته الخاصة.
     *
     * @throws \RuntimeException لو التذكرة مقفولة بالفعل.
     */
    public function replyAsCustomer(Ticket $ticket, Customer $customer, string $message): TicketReply
    {
        if ($ticket->status === 'closed') {
            throw new \RuntimeException('Cannot reply to closed ticket.');
        }

        $reply = TicketReply::create([
            'ticket_id'   => $ticket->id,
            'customer_id' => $customer->id,
            'user_id'     => null,
            'message'     => $message,
            'is_staff'    => false,
            'sent_at'     => now(),
        ]);

        ActivityLogService::log(
            tenantId: $ticket->tenant_id,
            userId: null,
            module: 'ticket',
            action: 'reply',
            description: "Customer replied to ticket {$ticket->ticket_number}"
        );

        return $reply;
    }

    /**
     * تغيير حالة التذكرة (Admin فقط).
     */
    public function changeStatus(Ticket $ticket, string $status, ?int $actingUserId): Ticket
    {
        $ticket->status = $status;

        if ($status === 'closed') {
            $ticket->closed_at = now();
        }

        $ticket->save();

        ActivityLogService::log(
            tenantId: $ticket->tenant_id,
            userId: $actingUserId,
            module: 'ticket',
            action: 'status',
            description: "Changed {$ticket->ticket_number} status to {$ticket->status}"
        );

        return $ticket;
    }

    /**
     * إغلاق التذكرة من طرف العميل.
     *
     * @throws \RuntimeException لو التذكرة مقفولة بالفعل.
     */
    public function closeByCustomer(Ticket $ticket): Ticket
    {
        if ($ticket->status === 'closed') {
            throw new \RuntimeException('Ticket already closed.');
        }

        $ticket->update([
            'status'    => 'closed',
            'closed_at' => now(),
        ]);

        ActivityLogService::log(
            tenantId: $ticket->tenant_id,
            userId: null,
            module: 'ticket',
            action: 'closed',
            description: "Customer closed ticket {$ticket->ticket_number}"
        );

        return $ticket->fresh();
    }

    /**
     * تعيين تذكرة لموظف معين.
     */
    public function assign(Ticket $ticket, User $user, ?int $actingUserId): Ticket
    {
        $ticket->update([
            'user_id' => $user->id,
        ]);

        ActivityLogService::log(
            tenantId: $ticket->tenant_id,
            userId: $actingUserId,
            module: 'ticket',
            action: 'assigned',
            description: "Assigned {$ticket->ticket_number} to {$user->name}"
        );

        return $ticket->fresh();
    }

    /**
     * إحصائيات لوحة تحكم الموظفين (كل التذاكر الخاصة بشركته، بفضل حماية Tenant التلقائية).
     */
    public function adminDashboardStats(): array
    {
        return [
            'total'         => Ticket::count(),
            'open'          => Ticket::where('status', 'open')->count(),
            'closed'        => Ticket::where('status', 'closed')->count(),
            'high_priority' => Ticket::where('priority', 'high')->count(),
            'today'         => Ticket::whereDate('created_at', today())->count(),
        ];
    }

    /**
     * إحصائيات لوحة تحكم العميل (تذاكره هو فقط).
     */
    public function customerDashboardStats(Customer $customer): array
    {
        $tickets = Ticket::where('customer_id', $customer->id);

        $lastTicket = (clone $tickets)->latest()->first();

        return [
            'statistics' => [
                'total'         => (clone $tickets)->count(),
                'open'          => (clone $tickets)->where('status', 'open')->count(),
                'closed'        => (clone $tickets)->where('status', 'closed')->count(),
                'high_priority' => (clone $tickets)->where('priority', 'high')->count(),
            ],
            'last_ticket' => $lastTicket,
        ];
    }
}
