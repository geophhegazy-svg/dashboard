<?php

declare(strict_types=1);

namespace App\Services;

use App\Contracts\TaskInterface;
use App\Data\Task\TaskData;
use App\Models\Task;

class TaskManager implements TaskInterface
{
    public function create(TaskData $data): Task
    {
        return Task::create($data->toArray());
    }

    public function update(Task $task, TaskData $data): Task
    {
        $task->update($data->toArray());

        return $task->refresh();
    }

    public function complete(Task $task): Task
    {
        $task->update([
            'status' => 'completed',
        ]);

        return $task->refresh();
    }

    public function cancel(Task $task): Task
    {
        $task->update([
            'status' => 'cancelled',
        ]);

        return $task->refresh();
    }

    public function reopen(Task $task): Task
    {
        $task->update([
            'status' => 'pending',
        ]);

        return $task->refresh();
    }

    public function assign(Task $task, int $userId): Task
    {
        $task->update([
            'assigned_to' => $userId,
        ]);

        return $task->refresh();
    }
}
