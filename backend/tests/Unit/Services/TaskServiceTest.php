<?php

declare(strict_types=1);

namespace Tests\Unit\Services;

use App\Models\Task;
use App\Models\Tenant;
use App\Modules\Task\Application\Services\TaskService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TaskServiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_task_can_be_created(): void
    {
        $tenant = Tenant::factory()->create();

        $service = app(TaskService::class);

        $task = $service->create([
            'tenant_id' => $tenant->id,
            'title' => 'Install Customer',
            'priority' => 'high',
            'status' => 'pending',
        ]);

        $this->assertInstanceOf(
            Task::class,
            $task
        );

        $this->assertDatabaseHas('tasks', [
            'id' => $task->id,
            'title' => 'Install Customer',
        ]);
    }

    public function test_task_can_be_updated(): void
    {
        $tenant = Tenant::factory()->create();

        $task = Task::factory()->create([
            'tenant_id' => $tenant->id,
        ]);

        $service = app(TaskService::class);

        $task = $service->update($task, [
            'title' => 'Updated Task',
        ]);

        $this->assertEquals(
            'Updated Task',
            $task->title
        );
    }

    public function test_task_can_be_completed(): void
    {
        $tenant = Tenant::factory()->create();

        $task = Task::factory()->create([
            'tenant_id' => $tenant->id,
        ]);

        $service = app(TaskService::class);

        $task = $service->complete($task);

        $this->assertEquals(
            'completed',
            $task->status
        );
    }

    public function test_task_can_be_cancelled(): void
    {
        $tenant = Tenant::factory()->create();

        $task = Task::factory()->create([
            'tenant_id' => $tenant->id,
        ]);

        $service = app(TaskService::class);

        $task = $service->cancel($task);

        $this->assertEquals(
            'cancelled',
            $task->status
        );
    }

    public function test_task_can_be_started(): void
    {
        $tenant = Tenant::factory()->create();

        $task = Task::factory()->create([
            'tenant_id' => $tenant->id,
        ]);

        $service = app(TaskService::class);

        $task = $service->start($task);

        $this->assertEquals(
            'in_progress',
            $task->status
        );
    }
}
