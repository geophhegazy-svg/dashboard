<?php

declare(strict_types=1);

namespace Tests\Feature\Modules\Ticket;

use App\Models\Tenant;
use App\Models\User;
use App\Modules\Customer\Infrastructure\Persistence\Models\Customer;
use App\Modules\Ticket\Application\Actions\ChangeTicketStatusAction;
use App\Modules\Ticket\Application\Actions\CloseTicketByCustomerAction;
use App\Modules\Ticket\Application\Actions\CreateCustomerTicketAction;
use App\Modules\Ticket\Application\Actions\ReplyAsCustomerAction;
use App\Modules\Ticket\Application\Actions\ReplyAsStaffAction;
use App\Modules\Ticket\Infrastructure\Persistence\Models\Ticket;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

final class TicketBusinessRulesTest extends TestCase
{
    use RefreshDatabase;

    public function test_customer_ticket_starts_open_with_opened_at_and_no_closed_at(): void
    {
        $tenant = Tenant::factory()->create();

        $customer = Customer::factory()->create([
            'tenant_id' => $tenant->id,
        ]);

        $ticket = app(CreateCustomerTicketAction::class)->execute(
            $customer,
            [
                'subject' => 'Test ticket',
                'description' => 'Test description',
            ],
        );

        $this->assertSame(
            'open',
            $ticket->status
        );

        $this->assertNotNull(
            $ticket->opened_at
        );

        $this->assertNull(
            $ticket->closed_at
        );
    }

    public function test_customer_can_close_open_ticket_and_closed_at_is_set(): void
    {
        $ticket = Ticket::factory()->create([
            'status' => 'open',
            'closed_at' => null,
        ]);

        $closed = app(CloseTicketByCustomerAction::class)->execute(
            $ticket
        );

        $this->assertSame(
            'closed',
            $closed->status
        );

        $this->assertNotNull(
            $closed->closed_at
        );
    }

    public function test_customer_cannot_close_already_closed_ticket(): void
    {
        $ticket = Ticket::factory()->closed()->create();

        $this->expectException(\RuntimeException::class);

        $this->expectExceptionMessage(
            'Ticket already closed.'
        );

        app(CloseTicketByCustomerAction::class)->execute(
            $ticket
        );
    }

    public function test_customer_cannot_reply_to_closed_ticket(): void
    {
        $ticket = Ticket::factory()->closed()->create();

        $customer = Customer::factory()->create([
            'tenant_id' => $ticket->tenant_id,
        ]);

        $this->expectException(\RuntimeException::class);

        $this->expectExceptionMessage(
            'Cannot reply to closed ticket.'
        );

        app(ReplyAsCustomerAction::class)->execute(
            $ticket,
            $customer,
            'Cannot reply',
        );
    }

    public function test_staff_cannot_reply_to_closed_ticket(): void
    {
        $ticket = Ticket::factory()->closed()->create();

        $user = User::factory()->create([
            'tenant_id' => $ticket->tenant_id,
        ]);

        $this->expectException(\RuntimeException::class);

        $this->expectExceptionMessage(
            'Ticket is already closed.'
        );

        app(ReplyAsStaffAction::class)->execute(
            $ticket,
            $user->id,
            'Cannot reply',
        );
    }

    public function test_changing_ticket_status_to_closed_sets_closed_at(): void
    {
        $ticket = Ticket::factory()->create([
            'status' => 'open',
            'closed_at' => null,
        ]);

        $closed = app(ChangeTicketStatusAction::class)->execute(
            $ticket,
            'closed',
            null,
        );

        $this->assertSame(
            'closed',
            $closed->status
        );

        $this->assertNotNull(
            $closed->closed_at
        );
    }
}
