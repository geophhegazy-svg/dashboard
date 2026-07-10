<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\Task;
use App\Models\Tenant;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class TaskControllerTest extends TestCase
{
    use RefreshDatabase;

    private function login(): void
    {
        $user = User::factory()->create();

        $user->assignRole('Super Admin');

        Sanctum::actingAs($user);
    }

    public function test_index_returns_tasks(): void
    {
        $this->login();

        $tenant = Tenant::factory()->create();

        Task::factory()->count(3)->create([
            'tenant_id' => $tenant->id,
        ]);

        $this->getJson('/api/tasks')
            ->assertOk();
    }

    public function test_store_creates_task(): void
    {
        $this->login();

        $tenant = Tenant::factory()->create();

        $this->postJson('/api/tasks', [
            'tenant_id' => $tenant->id,
            'title' => 'Install Customer',
            'priority' => 'high',
            'status' => 'pending',
        ])->assertSuccessful();

        $this->assertDatabaseHas('tasks', [
            'title' => 'Install Customer',
        ]);
    }

    public function test_update_task(): void
    {
        $this->login();

        $tenant = Tenant::factory()->create();

        $task = Task::factory()->create([
            'tenant_id' => $tenant->id,
        ]);

        $this->putJson("/api/tasks/{$task->id}", [
            'title' => 'Updated Task',
        ])->assertSuccessful();

        $this->assertDatabaseHas('tasks', [
            'id' => $task->id,
            'title' => 'Updated Task',
        ]);
    }

    public function test_delete_task(): void
    {
        $this->login();

        $tenant = Tenant::factory()->create();

        $task = Task::factory()->create([
            'tenant_id' => $tenant->id,
        ]);

        $this->deleteJson("/api/tasks/{$task->id}")
            ->assertSuccessful();

        $this->assertDatabaseMissing('tasks', [
            'id' => $task->id,
        ]);
    }
}
