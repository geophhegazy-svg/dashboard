<?php

declare(strict_types=1);

namespace App\Modules\Task\Infrastructure\Repositories;

use App\Modules\Task\Domain\Contracts\TaskRepositoryInterface;
use App\Modules\Task\Infrastructure\Persistence\Models\Task;
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

    public function save(Task $task): bool
    {
        return $task->save();
    }

    public function delete(Task $task): bool
    {
        return (bool) $task->delete();
    }
}
