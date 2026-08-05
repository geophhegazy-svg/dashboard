<?php

declare(strict_types=1);

namespace App\Modules\Task\Application\Services;

use App\Modules\Task\Infrastructure\Persistence\Models\Task;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use App\Modules\Task\Application\Workflows\CreateTaskWorkflow;
use App\Modules\Task\Application\Workflows\UpdateTaskWorkflow;
use App\Modules\Task\Application\Workflows\DeleteTaskWorkflow;
use App\Modules\Task\Application\Workflows\StartTaskWorkflow;
use App\Modules\Task\Application\Workflows\CompleteTaskWorkflow;
use App\Modules\Task\Application\Workflows\CancelTaskWorkflow;
use App\Modules\Task\Application\Workflows\ReopenTaskWorkflow;

final class TaskService
{
    public function __construct(
        private readonly CreateTaskWorkflow $createTask,
        private readonly UpdateTaskWorkflow $updateTask,
        private readonly DeleteTaskWorkflow $deleteTask,
        private readonly StartTaskWorkflow $startTask,
        private readonly CompleteTaskWorkflow $completeTask,
        private readonly CancelTaskWorkflow $cancelTask,
        private readonly ReopenTaskWorkflow $reopenTask,
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
        Task $task,
    ): Task {

        return $this->completeTask->execute(
            $task,
        );
    }

    public function cancel(Task $task): Task
    {
        return $this->cancelTask->execute($task);
    }

    public function reopen(Task $task): Task
    {
        return $this->reopenTask->execute($task);
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
