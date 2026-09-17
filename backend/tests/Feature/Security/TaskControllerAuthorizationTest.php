<?php

declare(strict_types=1);

namespace Tests\Feature\Security;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class TaskControllerAuthorizationTest extends TestCase
{
    use RefreshDatabase;

    private function authenticateAs(string $role): User
    {
        $user = User::factory()->create();

        $user->assignRole(
            Role::findOrCreate($role, 'web')
        );

        Sanctum::actingAs($user);

        return $user;
    }

    private function permission(string $name): Permission
    {
        return Permission::findOrCreate($name, 'web');
    }

    public function test_super_admin_has_all_task_permissions(): void
    {
        $role = Role::findOrCreate('Super Admin', 'web');

        $role->syncPermissions([
            $this->permission('task.view'),
            $this->permission('task.create'),
            $this->permission('task.update'),
            $this->permission('task.delete'),
        ]);

        $this->assertTrue($role->hasPermissionTo('task.view'));
        $this->assertTrue($role->hasPermissionTo('task.create'));
        $this->assertTrue($role->hasPermissionTo('task.update'));
        $this->assertTrue($role->hasPermissionTo('task.delete'));
    }

    public function test_tenant_admin_has_all_task_permissions(): void
    {
        $role = Role::findOrCreate('Tenant Admin', 'web');

        $role->syncPermissions([
            $this->permission('task.view'),
            $this->permission('task.create'),
            $this->permission('task.update'),
            $this->permission('task.delete'),
        ]);

        $this->assertTrue($role->hasPermissionTo('task.view'));
        $this->assertTrue($role->hasPermissionTo('task.create'));
        $this->assertTrue($role->hasPermissionTo('task.update'));
        $this->assertTrue($role->hasPermissionTo('task.delete'));
    }

    public function test_manager_has_view_create_update_but_not_delete(): void
    {
        $role = Role::findOrCreate('Manager', 'web');

        $role->syncPermissions([
            $this->permission('task.view'),
            $this->permission('task.create'),
            $this->permission('task.update'),
        ]);

        $this->assertTrue($role->hasPermissionTo('task.view'));
        $this->assertTrue($role->hasPermissionTo('task.create'));
        $this->assertTrue($role->hasPermissionTo('task.update'));
        $this->assertFalse($role->hasPermissionTo('task.delete'));
    }

    public function test_support_has_view_only(): void
    {
        $role = Role::findOrCreate('Support', 'web');

        $role->syncPermissions([
            $this->permission('task.view'),
        ]);

        $this->assertTrue($role->hasPermissionTo('task.view'));
        $this->assertFalse($role->hasPermissionTo('task.create'));
        $this->assertFalse($role->hasPermissionTo('task.update'));
        $this->assertFalse($role->hasPermissionTo('task.delete'));
    }

    public function test_technician_has_view_and_update_only(): void
    {
        $role = Role::findOrCreate('Technician', 'web');

        $role->syncPermissions([
            $this->permission('task.view'),
            $this->permission('task.update'),
        ]);

        $this->assertTrue($role->hasPermissionTo('task.view'));
        $this->assertFalse($role->hasPermissionTo('task.create'));
        $this->assertTrue($role->hasPermissionTo('task.update'));
        $this->assertFalse($role->hasPermissionTo('task.delete'));
    }

    public function test_accountant_has_no_task_permissions(): void
    {
        $role = Role::findOrCreate('Accountant', 'web');

        $role->syncPermissions([]);

        $this->assertFalse($role->hasPermissionTo('task.view'));
        $this->assertFalse($role->hasPermissionTo('task.create'));
        $this->assertFalse($role->hasPermissionTo('task.update'));
        $this->assertFalse($role->hasPermissionTo('task.delete'));
    }

    public function test_customer_has_no_task_permissions(): void
    {
        $role = Role::findOrCreate('Customer', 'web');

        $role->syncPermissions([]);

        $this->assertFalse($role->hasPermissionTo('task.view'));
        $this->assertFalse($role->hasPermissionTo('task.create'));
        $this->assertFalse($role->hasPermissionTo('task.update'));
        $this->assertFalse($role->hasPermissionTo('task.delete'));
    }

    public function test_task_store_requires_task_create_permission(): void
    {
        $this->authenticateAs('Manager');

        $tenant = \App\Models\Tenant::factory()->create();

        $this->postJson('/api/tasks', [
            'tenant_id' => $tenant->id,
            'title' => 'Authorization Task',
            'priority' => 'high',
            'status' => 'pending',
        ])->assertSuccessful();
    }

    public function test_task_store_denies_support_without_task_create_permission(): void
    {
        $this->authenticateAs('Support');

        $tenant = \App\Models\Tenant::factory()->create();

        $this->postJson('/api/tasks', [
            'tenant_id' => $tenant->id,
            'title' => 'Unauthorized Task',
            'priority' => 'high',
            'status' => 'pending',
        ])->assertForbidden();
    }

    public function test_task_update_requires_task_update_permission(): void
    {
        $this->authenticateAs('Technician');

        $tenant = \App\Models\Tenant::factory()->create();

        $task = \App\Modules\Task\Infrastructure\Persistence\Models\Task::factory()->create([
            'tenant_id' => $tenant->id,
        ]);

        $this->putJson("/api/tasks/{$task->id}", [
            'title' => 'Updated Authorization Task',
        ])->assertSuccessful();
    }

    public function test_task_update_denies_support_without_task_update_permission(): void
    {
        $this->authenticateAs('Support');

        $tenant = \App\Models\Tenant::factory()->create();

        $task = \App\Modules\Task\Infrastructure\Persistence\Models\Task::factory()->create([
            'tenant_id' => $tenant->id,
        ]);

        $this->putJson("/api/tasks/{$task->id}", [
            'title' => 'Unauthorized Update',
        ])->assertForbidden();
    }

    public function test_task_delete_requires_task_delete_permission(): void
    {
        $this->authenticateAs('Tenant Admin');

        $tenant = \App\Models\Tenant::factory()->create();

        $task = \App\Modules\Task\Infrastructure\Persistence\Models\Task::factory()->create([
            'tenant_id' => $tenant->id,
        ]);

        $this->deleteJson("/api/tasks/{$task->id}")
            ->assertSuccessful();
    }

    public function test_task_delete_denies_manager_without_task_delete_permission(): void
    {
        $this->authenticateAs('Manager');

        $tenant = \App\Models\Tenant::factory()->create();

        $task = \App\Modules\Task\Infrastructure\Persistence\Models\Task::factory()->create([
            'tenant_id' => $tenant->id,
        ]);

        $this->deleteJson("/api/tasks/{$task->id}")
            ->assertForbidden();
    }

    public function test_accountant_is_denied_from_task_endpoints(): void
    {
        $this->authenticateAs('Accountant');

        $tenant = \App\Models\Tenant::factory()->create();

        $task = \App\Modules\Task\Infrastructure\Persistence\Models\Task::factory()->create([
            'tenant_id' => $tenant->id,
        ]);

        $this->getJson('/api/tasks')
            ->assertForbidden();

        $this->postJson('/api/tasks', [
            'tenant_id' => $tenant->id,
            'title' => 'Unauthorized Task',
            'priority' => 'high',
            'status' => 'pending',
        ])->assertForbidden();

        $this->putJson("/api/tasks/{$task->id}", [
            'title' => 'Unauthorized Update',
        ])->assertForbidden();

        $this->deleteJson("/api/tasks/{$task->id}")
            ->assertForbidden();
    }

    public function test_customer_is_denied_from_task_endpoints(): void
    {
        $this->authenticateAs('Customer');

        $tenant = \App\Models\Tenant::factory()->create();

        $task = \App\Modules\Task\Infrastructure\Persistence\Models\Task::factory()->create([
            'tenant_id' => $tenant->id,
        ]);

        $this->getJson('/api/tasks')
            ->assertForbidden();

        $this->postJson('/api/tasks', [
            'tenant_id' => $tenant->id,
            'title' => 'Unauthorized Task',
            'priority' => 'high',
            'status' => 'pending',
        ])->assertForbidden();

        $this->putJson("/api/tasks/{$task->id}", [
            'title' => 'Unauthorized Update',
        ])->assertForbidden();

        $this->deleteJson("/api/tasks/{$task->id}")
            ->assertForbidden();
    }

    public function test_task_index_requires_task_view_permission(): void
    {
        $this->authenticateAs('Support');

        $this->getJson('/api/tasks')
            ->assertOk();
    }

    public function test_task_index_denies_role_without_task_view(): void
    {
        $this->authenticateAs('Accountant');

        $this->getJson('/api/tasks')
            ->assertForbidden();
    }
}
