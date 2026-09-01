<?php

declare(strict_types=1);

namespace Tests\Feature\Security;

use App\Models\Tenant;
use App\Models\User;
use App\Modules\Ticket\Infrastructure\Persistence\Models\Ticket;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Permission;
use Tests\TestCase;

final class TicketAssignmentOwnershipTest extends TestCase
{
    use RefreshDatabase;


    public function test_tenant_user_can_assign_ticket_to_user_from_same_tenant(): void
    {
        Permission::findOrCreate('tickets.update', 'web');

        $tenant = Tenant::factory()->create();

        $actor = User::factory()->create([
            'tenant_id' => $tenant->id,
        ]);

        $assignee = User::factory()->create([
            'tenant_id' => $tenant->id,
        ]);

        $ticket = Ticket::factory()->create([
            'tenant_id' => $tenant->id,
            'user_id' => null,
        ]);

        $actor->givePermissionTo('tickets.update');

        $this->actingAs($actor, 'sanctum')
            ->postJson("/api/tickets/{$ticket->id}/assign", [
                'user_id' => $assignee->id,
            ])
            ->assertOk();

        $this->assertDatabaseHas('tickets', [
            'id' => $ticket->id,
            'user_id' => $assignee->id,
        ]);
    }


    public function test_super_admin_can_assign_ticket_to_user_from_another_tenant(): void
    {
        Permission::findOrCreate('tickets.update', 'web');
        \Spatie\Permission\Models\Role::findOrCreate('Super Admin', 'web');

        $tenantA = Tenant::factory()->create();
        $tenantB = Tenant::factory()->create();

        $actor = User::factory()->create([
            'tenant_id' => $tenantA->id,
        ]);

        $actor->assignRole('Super Admin');
        $actor->givePermissionTo('tickets.update');

        $assignee = User::factory()->create([
            'tenant_id' => $tenantB->id,
        ]);

        $ticket = Ticket::factory()->create([
            'tenant_id' => $tenantA->id,
            'user_id' => null,
        ]);

        $this->actingAs($actor, 'sanctum')
            ->postJson("/api/tickets/{$ticket->id}/assign", [
                'user_id' => $assignee->id,
            ])
            ->assertOk();

        $this->assertDatabaseHas('tickets', [
            'id' => $ticket->id,
            'user_id' => $assignee->id,
        ]);
    }

    public function test_tenant_user_cannot_assign_ticket_to_user_from_another_tenant(): void
    {
        Permission::findOrCreate('tickets.update', 'web');

        $tenantA = Tenant::factory()->create();
        $tenantB = Tenant::factory()->create();

        $actor = User::factory()->create([
            'tenant_id' => $tenantA->id,
        ]);

        $assignee = User::factory()->create([
            'tenant_id' => $tenantB->id,
        ]);

        $ticket = Ticket::factory()->create([
            'tenant_id' => $tenantA->id,
            'user_id' => null,
        ]);

        $actor->givePermissionTo('tickets.update');

        $this->actingAs($actor, 'sanctum')
            ->postJson("/api/tickets/{$ticket->id}/assign", [
                'user_id' => $assignee->id,
            ])
            ->assertForbidden();

        $this->assertDatabaseHas('tickets', [
            'id' => $ticket->id,
            'user_id' => null,
        ]);
    }
}
