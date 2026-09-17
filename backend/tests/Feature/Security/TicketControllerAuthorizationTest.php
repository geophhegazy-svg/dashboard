<?php

declare(strict_types=1);

namespace Tests\Feature\Security;

use App\Models\Tenant;
use App\Models\User;
use App\Modules\Customer\Infrastructure\Persistence\Models\Customer;
use App\Modules\Ticket\Infrastructure\Persistence\Models\Ticket;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Spatie\Permission\Models\Permission;
use Tests\TestCase;

final class TicketControllerAuthorizationTest extends TestCase
{
    use RefreshDatabase;

    private function authenticate(array $permissions = []): User
    {
        $tenant = Tenant::factory()->create();

        $user = User::factory()->create([
            'tenant_id' => $tenant->id,
        ]);

        foreach ($permissions as $permission) {
            $permissionModel = Permission::findOrCreate($permission, 'web');
            $user->givePermissionTo($permissionModel);
        }

        Sanctum::actingAs($user);

        return $user;
    }

    private function createTicket(User $user): Ticket
    {
        return Ticket::factory()->create([
            'tenant_id' => $user->tenant_id,
            'customer_id' => Customer::factory()->create([
                'tenant_id' => $user->tenant_id,
            ])->id,
        ]);
    }

    private function storePayload(Customer $customer): array
    {
        return [
            'customer_id' => $customer->id,
            'user_id' => null,
            'ticket_number' => 'TKT-' . fake()->unique()->numerify('##########'),
            'subject' => 'Authorization test ticket',
            'description' => 'Authorization contract test.',
            'priority' => 'medium',
            'status' => 'open',
            'opened_at' => now()->toDateTimeString(),
            'closed_at' => null,
            'notes' => null,
        ];
    }

    public function test_index_requires_view_permission(): void
    {
        $this->authenticate();

        $this->getJson('/api/tickets')
            ->assertForbidden();
    }

    public function test_index_allows_view_permission(): void
    {
        $this->authenticate(['tickets.view']);

        $this->getJson('/api/tickets')
            ->assertOk();
    }

    public function test_store_requires_create_permission(): void
    {
        $user = $this->authenticate();

        $customer = Customer::factory()->create([
            'tenant_id' => $user->tenant_id,
        ]);

        $this->postJson('/api/tickets', $this->storePayload($customer))
            ->assertForbidden();
    }

    public function test_store_allows_create_permission(): void
    {
        $user = $this->authenticate(['tickets.create']);

        $customer = Customer::factory()->create([
            'tenant_id' => $user->tenant_id,
        ]);

        $this->postJson('/api/tickets', $this->storePayload($customer))
            ->assertSuccessful();
    }

    public function test_show_requires_view_permission(): void
    {
        $user = $this->authenticate();
        $ticket = $this->createTicket($user);

        $this->getJson("/api/tickets/{$ticket->id}")
            ->assertForbidden();
    }

    public function test_show_allows_view_permission(): void
    {
        $user = $this->authenticate(['tickets.view']);
        $ticket = $this->createTicket($user);

        $this->getJson("/api/tickets/{$ticket->id}")
            ->assertOk();
    }

    public function test_update_requires_update_permission(): void
    {
        $user = $this->authenticate();
        $ticket = $this->createTicket($user);

        $payload = [
            'customer_id' => $ticket->customer_id,
            'user_id' => null,
            'ticket_number' => 'TKT-' . fake()->unique()->numerify('##########'),
            'subject' => 'Authorization update test ticket',
            'description' => 'Authorization update contract test.',
            'priority' => 'medium',
            'status' => 'open',
            'opened_at' => $ticket->opened_at?->toDateTimeString(),
            'closed_at' => null,
            'notes' => null,
        ];

        $this->putJson("/api/tickets/{$ticket->id}", $payload)
            ->assertForbidden();
    }

    public function test_update_allows_update_permission(): void
    {
        $user = $this->authenticate(['tickets.update']);
        $ticket = $this->createTicket($user);

        $payload = [
            'customer_id' => $ticket->customer_id,
            'user_id' => null,
            'ticket_number' => 'TKT-' . fake()->unique()->numerify('##########'),
            'subject' => 'Updated authorization test ticket',
            'description' => 'Updated authorization contract test.',
            'priority' => 'high',
            'status' => 'open',
            'opened_at' => $ticket->opened_at?->toDateTimeString(),
            'closed_at' => null,
            'notes' => null,
        ];

        $this->putJson("/api/tickets/{$ticket->id}", $payload)
            ->assertSuccessful();
    }

    public function test_delete_requires_delete_permission(): void
    {
        $user = $this->authenticate();
        $ticket = $this->createTicket($user);

        $this->deleteJson("/api/tickets/{$ticket->id}")
            ->assertForbidden();
    }

    public function test_delete_allows_delete_permission(): void
    {
        $user = $this->authenticate(['tickets.delete']);
        $ticket = $this->createTicket($user);

        $this->deleteJson("/api/tickets/{$ticket->id}")
            ->assertSuccessful();
    }

    public function test_dashboard_requires_view_permission(): void
    {
        $this->authenticate();

        $this->getJson('/api/tickets/dashboard/statistics')
            ->assertForbidden();
    }

    public function test_dashboard_allows_view_permission(): void
    {
        $this->authenticate(['tickets.view']);

        $this->getJson('/api/tickets/dashboard/statistics')
            ->assertOk();
    }

    public function test_messages_requires_view_permission(): void
    {
        $user = $this->authenticate();
        $ticket = $this->createTicket($user);

        $this->getJson("/api/tickets/{$ticket->id}/messages")
            ->assertForbidden();
    }

    public function test_messages_allows_view_permission(): void
    {
        $user = $this->authenticate(['tickets.view']);
        $ticket = $this->createTicket($user);

        $this->getJson("/api/tickets/{$ticket->id}/messages")
            ->assertOk();
    }

    public function test_reply_requires_reply_permission(): void
    {
        $user = $this->authenticate();
        $ticket = $this->createTicket($user);

        $this->postJson("/api/tickets/{$ticket->id}/reply", [
            'message' => 'Authorization test reply.',
        ])->assertForbidden();
    }

    public function test_reply_allows_reply_permission(): void
    {
        $user = $this->authenticate(['tickets.reply']);
        $ticket = $this->createTicket($user);

        $this->postJson("/api/tickets/{$ticket->id}/reply", [
            'message' => 'Authorization test reply.',
        ])->assertSuccessful();
    }

    public function test_change_status_requires_change_status_permission(): void
    {
        $user = $this->authenticate();
        $ticket = $this->createTicket($user);

        $this->postJson("/api/tickets/{$ticket->id}/status", [
            'status' => 'in_progress',
        ])->assertForbidden();
    }

    public function test_change_status_allows_change_status_permission(): void
    {
        $user = $this->authenticate(['tickets.change_status']);
        $ticket = $this->createTicket($user);

        $this->postJson("/api/tickets/{$ticket->id}/status", [
            'status' => 'in_progress',
        ])->assertSuccessful();
    }

    public function test_assign_requires_update_permission(): void
    {
        $user = $this->authenticate();
        $ticket = $this->createTicket($user);
        $assignee = User::factory()->create([
            'tenant_id' => $user->tenant_id,
        ]);

        $this->postJson("/api/tickets/{$ticket->id}/assign", [
            'user_id' => $assignee->id,
        ])->assertForbidden();
    }
}
