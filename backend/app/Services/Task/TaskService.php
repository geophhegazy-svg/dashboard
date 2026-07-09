<?php

declare(strict_types=1);

namespace App\Services\Task;

use App\Models\Task;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class TaskService
{
    public function paginate(): LengthAwarePaginator
    {
        return Task::latest()->paginate();
    }

    public function create(array $data): Task
    {
        return Task::create($data);
    }

    public function update(
        Task $task,
        array $data
    ): Task {

        $task->update($data);

        return $task->fresh();
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
        Task $task
    ): Task {

        $task->update([
            'status' => 'in_progress',
            'started_at' => now(),
        ]);

        return $task->fresh();
    }

    public function delete(
        Task $task
    ): void {

        $task->delete();
    }
}
