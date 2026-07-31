<?php

declare(strict_types=1);

namespace App\Modules\Task\Application\Services;

use App\Models\Task;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use App\Modules\Task\Application\Workflows\CreateTaskWorkflow;
use App\Modules\Task\Application\Workflows\UpdateTaskWorkflow;
use App\Modules\Task\Application\Workflows\DeleteTaskWorkflow;
use App\Modules\Task\Application\Workflows\StartTaskWorkflow;

final class TaskService
{
    public function __construct(
        private readonly CreateTaskWorkflow $createTask,
        private readonly UpdateTaskWorkflow $updateTask,
        private readonly DeleteTaskWorkflow $deleteTask,
        private readonly StartTaskWorkflow $startTask,
    ) {}

    public function paginate(): LengthAwarePaginator
    {
        return Task::latest()->paginate();
    }

    public function create(
        array $data
    ): Task {

        $task = new Task($data);

        return $this->createTask->execute(
            $task,
        );
    }

    public function update(
        Task $task,
        array $data,
    ): Task {

        return $this->updateTask->execute(
            $task,
            $data,
        );
    }

    public function complete(
        Task $task
    ): Task {

        $task->update([
            'status' => 'completed',
            'completed_at' => now(),
        ]);

        return $task->fresh();
    }

    public function cancel(
        Task $task
    ): Task {

        $task->update([
            'status' => 'cancelled',
            'cancelled_at' => now(),
        ]);

        return $task->fresh();
    }

    public function reopen(
        Task $task
    ): Task {

        $task->update([
            'status' => 'pending',
            'started_at' => null,
            'completed_at' => null,
            'cancelled_at' => null,
        ]);

        return $task->fresh();
    }

    public function start(
        Task $task,
    ): Task {

        return $this->startTask->execute(
            $task,
        );
    }

    public function delete(
        Task $task,
    ): bool {

        return $this->deleteTask->execute(
            $task,
        );
    }
}
