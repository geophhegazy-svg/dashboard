<?php

declare(strict_types=1);

namespace Tests\Feature\Security;

use App\Models\Tenant;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Tests\TestCase;

final class UserControllerAuthorizationTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_update_requires_users_update_permission(): void
    {
        Permission::findOrCreate('users.view', 'web');
        Permission::findOrCreate('users.update', 'web');

        $actor = User::factory()->create();
        $target = User::factory()->create();

        $this->actingAs($actor, 'sanctum')
            ->putJson("/api/users/{$target->id}", [
                'name' => 'Updated Name',
            ])
            ->assertForbidden();
    }

    public function test_user_can_update_with_users_update_permission(): void
    {
        Permission::findOrCreate('users.update', 'web');

        $actor = User::factory()->create();
        $actor->givePermissionTo('users.update');

        $target = User::factory()->create([
            'name' => 'Original Name',
        ]);

        $this->actingAs($actor, 'sanctum')
            ->putJson("/api/users/{$target->id}", [
                'name' => 'Updated Name',
            ])
            ->assertOk()
            ->assertJsonPath('data.name', 'Updated Name');

        $this->assertDatabaseHas('users', [
            'id' => $target->id,
            'name' => 'Updated Name',
        ]);
    }

    public function test_user_update_preserves_existing_email_when_email_is_not_submitted(): void
    {
        Permission::findOrCreate('users.update', 'web');

        $actor = User::factory()->create();
        $actor->givePermissionTo('users.update');

        $target = User::factory()->create([
            'name' => 'Original Name',
        ]);

        $email = $target->email;

        $this->actingAs($actor, 'sanctum')
            ->patchJson("/api/users/{$target->id}", [
                'name' => 'Updated Name',
            ])
            ->assertOk();

        $this->assertDatabaseHas('users', [
            'id' => $target->id,
            'email' => $email,
            'name' => 'Updated Name',
        ]);
    }

    public function test_user_update_can_change_password(): void
    {
        Permission::findOrCreate('users.update', 'web');

        $actor = User::factory()->create();
        $actor->givePermissionTo('users.update');

        $target = User::factory()->create([
            'password' => 'old-password',
        ]);

        $this->actingAs($actor, 'sanctum')
            ->putJson("/api/users/{$target->id}", [
                'password' => 'new-password',
            ])
            ->assertOk();

        $this->assertTrue(
            Hash::check(
                'new-password',
                $target->refresh()->password
            )
        );
    }

    public function test_tenant_user_cannot_list_users_from_another_tenant(): void
    {
        Permission::findOrCreate('users.view', 'web');

        $tenantA = Tenant::factory()->create();
        $tenantB = Tenant::factory()->create();

        $actor = User::factory()->create([
            'tenant_id' => $tenantA->id,
        ]);

        $actor->givePermissionTo('users.view');

        User::factory()->create([
            'tenant_id' => $tenantA->id,
            'name' => 'Tenant A User',
        ]);

        User::factory()->create([
            'tenant_id' => $tenantB->id,
            'name' => 'Tenant B User',
        ]);

        $response = $this->actingAs($actor, 'sanctum')
            ->getJson('/api/users');

        $response
            ->assertOk()
            ->assertJsonMissing([
                'name' => 'Tenant B User',
            ])
            ->assertJsonFragment([
                'name' => 'Tenant A User',
            ]);
    }
}
