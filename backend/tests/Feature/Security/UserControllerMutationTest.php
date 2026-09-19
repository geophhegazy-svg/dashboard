<?php

declare(strict_types=1);

namespace Tests\Feature\Security;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class UserControllerMutationTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_store_requires_users_create_permission(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)
            ->postJson('/api/users', [
                'name' => 'Created User',
                'email' => 'created@example.com',
                'password' => 'password123',
                'tenant_id' => $user->tenant_id,
                'role' => 'Manager',
            ]);

        $response->assertForbidden();

        $this->assertDatabaseMissing('users', [
            'email' => 'created@example.com',
        ]);
    }

    public function test_user_store_creates_user_and_assigns_role(): void
    {
        $permission = Permission::findOrCreate('users.create', 'web');

        $role = Role::findOrCreate('Manager', 'web');
        $role->givePermissionTo($permission);

        $admin = User::factory()->create([
            'tenant_id' => User::factory()->create()->tenant_id,
        ]);

        $admin->assignRole($role);

        $response = $this->actingAs($admin)
            ->postJson('/api/users', [
                'name' => 'Created User',
                'email' => 'created@example.com',
                'password' => 'password123',
                'tenant_id' => $admin->tenant_id,
                'role' => 'Manager',
            ]);

        $response->assertSuccessful();

        $this->assertDatabaseHas('users', [
            'email' => 'created@example.com',
            'tenant_id' => $admin->tenant_id,
        ]);

        $created = User::where('email', 'created@example.com')->firstOrFail();

        $this->assertTrue(
            Hash::check('password123', $created->password)
        );

        $this->assertTrue(
            $created->hasRole('Manager')
        );
    }

    public function test_user_destroy_requires_users_delete_permission(): void
    {
        $user = User::factory()->create();
        $target = User::factory()->create([
            'tenant_id' => $user->tenant_id,
        ]);

        $response = $this->actingAs($user)
            ->deleteJson("/api/users/{$target->id}");

        $response->assertForbidden();

        $this->assertDatabaseHas('users', [
            'id' => $target->id,
        ]);
    }

    public function test_user_destroy_deletes_user_with_users_delete_permission(): void
    {
        $permission = Permission::findOrCreate('users.delete', 'web');

        $role = Role::findOrCreate('Manager', 'web');
        $role->givePermissionTo($permission);

        $admin = User::factory()->create();
        $admin->assignRole($role);

        $target = User::factory()->create([
            'tenant_id' => $admin->tenant_id,
        ]);

        $response = $this->actingAs($admin)
            ->deleteJson("/api/users/{$target->id}");

        $response->assertSuccessful();

        $this->assertDatabaseMissing('users', [
            'id' => $target->id,
        ]);
    }
}
