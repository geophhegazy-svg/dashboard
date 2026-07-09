<?php

declare(strict_types=1);

namespace App\Repositories\Eloquent;

use App\Contracts\Repositories\TaskRepositoryInterface;
use App\Models\Task;
use Illuminate\Database\Eloquent\Collection;

class TaskRepository implements TaskRepositoryInterface
{
    public function all(): Collection
    {
        return Task::query()->latest()->get();
    }

    public function find(int $id): ?Task
    {
        return Task::find($id);
    }

    public function create(array $attributes): Task
    {
        return Task::create($attributes);
    }

    public function update(Task $task, array $attributes): Task
    {
        $task->update($attributes);

        return $task->refresh();
    }

    public function delete(Task $task): bool
    {
        return (bool) $task->delete();
    }
}
