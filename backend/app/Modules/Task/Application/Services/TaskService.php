<?php

declare(strict_types=1);

namespace App\Modules\Task\Application\Services;

use App\Modules\Task\Application\Actions\CancelTaskAction;
use App\Modules\Task\Application\Actions\CompleteTaskAction;
use App\Modules\Task\Application\Actions\CreateTaskAction;
use App\Modules\Task\Application\Actions\DeleteTaskAction;
use App\Modules\Task\Application\Actions\ReopenTaskAction;
use App\Modules\Task\Application\Actions\StartTaskAction;
use App\Modules\Task\Application\Actions\UpdateTaskAction;
use App\Modules\Task\Infrastructure\Persistence\Models\Task;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

final class TaskService
{
    public function __construct(
        private readonly CreateTaskAction $createTask,
        private readonly UpdateTaskAction $updateTask,
        private readonly DeleteTaskAction $deleteTask,
        private readonly StartTaskAction $startTask,
        private readonly CompleteTaskAction $completeTask,
        private readonly CancelTaskAction $cancelTask,
        private readonly ReopenTaskAction $reopenTask,
    ) {}

    public function paginate(): LengthAwarePaginator
    {
        return Task::latest()->paginate();
    }

    public function create(
        array $data,
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

    public function cancel(
        Task $task,
    ): Task {

        return $this->cancelTask->execute(
            $task,
        );
    }

    public function reopen(
        Task $task,
    ): Task {

        return $this->reopenTask->execute(
            $task,
        );
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
