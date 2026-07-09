<?php

declare(strict_types=1);

namespace Tests\Unit\Services;

use App\Models\Task;
use App\Services\Task\TaskService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TaskServiceTest extends TestCase
{
    use RefreshDatabase;

    private TaskService $service;

    protected function setUp(): void
    {
        parent::setUp();

        $this->service = app(TaskService::class);
    }

    public function test_task_can_be_created(): void
    {
        $task = $this->service->create([
            'tenant_id' => 1,
            'title' => 'Install customer',
            'priority' => 'high',
            'status' => 'pending',
        ]);

        $this->assertDatabaseHas('tasks', [
            'id' => $task->id,
            'title' => 'Install customer',
        ]);
    }

    public function test_task_can_be_updated(): void
    {
        $task = Task::factory()->create();

        $updated = $this->service->update($task, [
            'title' => 'Updated Task',
        ]);

        $this->assertEquals(
            'Updated Task',
            $updated->title
        );
    }

    public function test_task_can_be_completed(): void
    {
        $task = Task::factory()->create();

        $task = $this->service->complete($task);

        $this->assertEquals(
            'completed',
            $task->status
        );

        $this->assertNotNull(
            $task->completed_at
        );
    }

    public function test_task_can_be_cancelled(): void
    {
        $task = Task::factory()->create();

        $task = $this->service->cancel($task);

        $this->assertEquals(
            'cancelled',
            $task->status
        );

        $this->assertNotNull(
            $task->cancelled_at
        );
    }

    public function test_task_can_be_started(): void
    {
        $task = Task::factory()->create();

        $task = $this->service->start($task);

        $this->assertEquals(
            'in_progress',
            $task->status
        );

        $this->assertNotNull(
            $task->started_at
        );
    }
}
