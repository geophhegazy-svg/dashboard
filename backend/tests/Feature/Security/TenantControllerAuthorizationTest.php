<?php

declare(strict_types=1);

namespace Tests\Feature\Security;

use App\Models\Tenant;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Permission;
use Tests\TestCase;

final class TenantControllerAuthorizationTest extends TestCase
{
    use RefreshDatabase;

    public function test_tenant_index_requires_view_permission(): void
    {
        Permission::findOrCreate('tenants.view', 'web');

        $actor = User::factory()->create();

        $this->actingAs($actor, 'sanctum')
            ->getJson('/api/tenants')
            ->assertForbidden();
    }

    public function test_tenant_index_allows_view_permission(): void
    {
        Permission::findOrCreate('tenants.view', 'web');

        $actor = User::factory()->create();
        $actor->givePermissionTo('tenants.view');

        $this->actingAs($actor, 'sanctum')
            ->getJson('/api/tenants')
            ->assertOk();
    }

    public function test_tenant_store_requires_create_permission(): void
    {
        Permission::findOrCreate('tenants.create', 'web');

        $actor = User::factory()->create();

        $this->actingAs($actor, 'sanctum')
            ->postJson('/api/tenants', [
                'name' => 'Acme',
                'status' => 'active',
            ])
            ->assertForbidden();
    }

    public function test_tenant_store_allows_create_permission(): void
    {
        Permission::findOrCreate('tenants.create', 'web');

        $actor = User::factory()->create();
        $actor->givePermissionTo('tenants.create');

        $this->actingAs($actor, 'sanctum')
            ->postJson('/api/tenants', [
                'name' => 'Acme',
                'status' => 'active',
            ])
            ->assertCreated();
    }

    public function test_tenant_show_requires_view_permission(): void
    {
        Permission::findOrCreate('tenants.view', 'web');

        $actor = User::factory()->create();
        $tenant = Tenant::factory()->create();

        $this->actingAs($actor, 'sanctum')
            ->getJson("/api/tenants/{$tenant->id}")
            ->assertForbidden();
    }

    public function test_tenant_update_requires_update_permission(): void
    {
        Permission::findOrCreate('tenants.update', 'web');

        $actor = User::factory()->create();
        $tenant = Tenant::factory()->create();

        $this->actingAs($actor, 'sanctum')
            ->putJson("/api/tenants/{$tenant->id}", [
                'name' => 'Updated Tenant',
            ])
            ->assertForbidden();
    }

    public function test_tenant_update_allows_update_permission(): void
    {
        Permission::findOrCreate('tenants.update', 'web');

        $actor = User::factory()->create();
        $actor->givePermissionTo('tenants.update');

        $tenant = Tenant::factory()->create([
            'name' => 'Original Tenant',
        ]);

        $this->actingAs($actor, 'sanctum')
            ->putJson("/api/tenants/{$tenant->id}", [
                'name' => 'Updated Tenant',
            ])
            ->assertOk();

        $this->assertDatabaseHas('tenants', [
            'id' => $tenant->id,
            'name' => 'Updated Tenant',
        ]);
    }

    public function test_tenant_destroy_requires_delete_permission(): void
    {
        Permission::findOrCreate('tenants.delete', 'web');

        $actor = User::factory()->create();
        $tenant = Tenant::factory()->create();

        $this->actingAs($actor, 'sanctum')
            ->deleteJson("/api/tenants/{$tenant->id}")
            ->assertForbidden();
    }

    public function test_tenant_destroy_allows_delete_permission(): void
    {
        Permission::findOrCreate('tenants.delete', 'web');

        $actor = User::factory()->create();
        $actor->givePermissionTo('tenants.delete');

        $tenant = Tenant::factory()->create();

        $this->actingAs($actor, 'sanctum')
            ->deleteJson("/api/tenants/{$tenant->id}")
            ->assertOk();

        $this->assertDatabaseMissing('tenants', [
            'id' => $tenant->id,
        ]);
    }
}
