<?php

declare(strict_types=1);

namespace App\Modules\Ticket;

use App\Modules\Customer\Infrastructure\Persistence\Models\Customer;
use App\Modules\Ticket\Infrastructure\Persistence\Models\Ticket;
use App\Modules\Ticket\Infrastructure\Persistence\Models\TicketReply;
use App\Models\User;
use App\Modules\Activity\Application\Workflows\LogActivityWorkflow;
use App\Modules\Ticket\Application\Workflows\UpdateTicketWorkflow;
use App\Modules\Ticket\Application\Workflows\CreateTicketWorkflow;
use App\Modules\Ticket\Application\Workflows\DeleteTicketWorkflow;
use App\Modules\Ticket\Application\Workflows\CreateTicketReplyWorkflow;
use App\Modules\Ticket\Application\Workflows\ChangeTicketStatusWorkflow;
use App\Modules\Ticket\Application\Workflows\AssignTicketWorkflow;
use App\Modules\Ticket\Application\Workflows\GetAdminTicketStatisticsWorkflow;
use App\Modules\Ticket\Application\Workflows\GetCustomerTicketStatisticsWorkflow;

class TicketService
{

    public function __construct(
        private readonly CreateTicketWorkflow $createTicketWorkflow,
        private readonly UpdateTicketWorkflow $updateTicketWorkflow,
        private readonly DeleteTicketWorkflow $deleteTicketWorkflow,
        private readonly CreateTicketReplyWorkflow $createTicketReplyWorkflow,
        private readonly ChangeTicketStatusWorkflow $changeTicketStatusWorkflow,
        private readonly LogActivityWorkflow $logActivity,
        private readonly AssignTicketWorkflow $assignTicketWorkflow,
        private readonly GetAdminTicketStatisticsWorkflow $adminStatisticsWorkflow,
        private readonly GetCustomerTicketStatisticsWorkflow $customerStatisticsWorkflow,
    ) {}
    /**
     * إنشاء تذكرة جديدة من لوحة تحكم الموظفين (Admin).
     */
    public function createFromAdmin(array $data, ?int $actingUserId): Ticket
    {
        $ticket = $this->createTicketWorkflow->execute(
            $data,
        );

        $this->logActivity->execute(
            [
                'tenant_id' => $ticket->tenant_id,
                'module'    => 'ticket',
                'action'    => 'created',
            ],
            [
                'user_id'     => $actingUserId,
                'description' => "Created ticket {$ticket->ticket_number}",
                'ip_address'  => request()->ip(),
            ],
        );

        return $ticket;
    }

    /**
     * إنشاء تذكرة جديدة من بوابة العميل.
     */
    public function createFromCustomer(Customer $customer, array $data): Ticket
    {
        $ticket = $this->createTicketWorkflow->execute([

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

        $this->logActivity->execute(
            [
                'tenant_id' => $ticket->tenant_id,
                'module'    => 'ticket',
                'action'    => 'created',
            ],
            [
                'user_id'     => null,
                'description' => "Customer {$customer->name} created ticket {$ticket->ticket_number}",
                'ip_address'  => request()->ip(),
            ],
        );

        return $ticket;
    }

    /**
     * تحديث بيانات تذكرة من لوحة تحكم الموظفين.
     */
    public function updateFromAdmin(Ticket $ticket, array $data, ?int $actingUserId): Ticket
    {
        $ticket = $this->updateTicketWorkflow->execute(
            $ticket,
            $data,
        );

        $this->logActivity->execute(
            [
                'tenant_id' => $ticket->tenant_id,
                'module'    => 'ticket',
                'action'    => 'updated',
            ],
            [
                'user_id'     => $actingUserId,
                'description' => "Updated ticket {$ticket->ticket_number}",
                'ip_address'  => request()->ip(),
            ],
        );

        return $ticket;
    }

    /**
     * حذف تذكرة (Admin فقط).
     */
    public function delete(Ticket $ticket, ?int $actingUserId): void
    {
        $this->logActivity->execute(
            [
                'tenant_id' => $ticket->tenant_id,
                'module'    => 'ticket',
                'action'    => 'deleted',
            ],
            [
                'user_id'     => $actingUserId,
                'description' => "Deleted ticket {$ticket->ticket_number}",
                'ip_address'  => request()->ip(),
            ],
        );

        $this->deleteTicketWorkflow->execute(
            $ticket,
        );
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

        $reply = $this->createTicketReplyWorkflow->execute([
            'ticket_id'   => $ticket->id,
            'customer_id' => null,
            'user_id'     => $userId,
            'message'     => $message,
            'is_staff'    => true,
            'sent_at'     => now(),
        ]);

        $this->logActivity->execute(
            [
                'tenant_id' => $ticket->tenant_id,
                'module'    => 'ticket',
                'action'    => 'reply',
            ],
            [
                'user_id'     => $userId,
                'description' => "Staff replied to {$ticket->ticket_number}",
                'ip_address'  => request()->ip(),
            ],
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

        $reply = $this->createTicketReplyWorkflow->execute([
            'ticket_id'   => $ticket->id,
            'customer_id' => $customer->id,
            'user_id'     => null,
            'message'     => $message,
            'is_staff'    => false,
            'sent_at'     => now(),
        ]);

        $this->logActivity->execute(
            [
                'tenant_id' => $ticket->tenant_id,
                'module'    => 'ticket',
                'action'    => 'reply',
            ],
            [
                'user_id'     => null,
                'description' => "Customer replied to ticket {$ticket->ticket_number}",
                'ip_address'  => request()->ip(),
            ],
        );

        return $reply;
    }

    /**
     * تغيير حالة التذكرة (Admin فقط).
     */
    public function changeStatus(Ticket $ticket, string $status, ?int $actingUserId): Ticket
    {
        $ticket = $this->changeTicketStatusWorkflow->execute(
            $ticket,
            $status,
        );

        $this->logActivity->execute(
            [
                'tenant_id' => $ticket->tenant_id,
                'module'    => 'ticket',
                'action'    => 'status',
            ],
            [
                'user_id'     => $actingUserId,
                'description' => "Changed {$ticket->ticket_number} status to {$ticket->status}",
                'ip_address'  => request()->ip(),
            ],
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

        $ticket = $this->changeTicketStatusWorkflow->execute(
            $ticket,
            'closed',
        );

        $this->logActivity->execute(
            [
                'tenant_id' => $ticket->tenant_id,
                'module'    => 'ticket',
                'action'    => 'closed',
            ],
            [
                'user_id'     => null,
                'description' => "Customer closed ticket {$ticket->ticket_number}",
                'ip_address'  => request()->ip(),
            ],
        );

        return $ticket;
    }

    /**
     * تعيين تذكرة لموظف معين.
     */
    public function assign(Ticket $ticket, User $user, ?int $actingUserId): Ticket
    {
        $ticket = $this->assignTicketWorkflow->execute(
            $ticket,
            $user,
        );

        $this->logActivity->execute(
            [
                'tenant_id' => $ticket->tenant_id,
                'module'    => 'ticket',
                'action'    => 'assigned',
            ],
            [
                'user_id'     => $actingUserId,
                'description' => "Assigned {$ticket->ticket_number} to {$user->name}",
                'ip_address'  => request()->ip(),
            ],
        );

        return $ticket;
    }

    /**
     * إحصائيات لوحة تحكم الموظفين (كل التذاكر الخاصة بشركته، بفضل حماية Tenant التلقائية).
     */
    public function adminDashboardStats(): array
    {
        return $this->adminStatisticsWorkflow->execute();
    }

    /**
     * إحصائيات لوحة تحكم العميل (تذاكره هو فقط).
     */
    public function customerDashboardStats(
        Customer $customer,
    ): array {

        return $this->customerStatisticsWorkflow->execute(
            $customer,
        );
    }
}
