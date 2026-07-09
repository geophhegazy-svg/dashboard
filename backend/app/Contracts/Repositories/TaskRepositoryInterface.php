<?php

declare(strict_types=1);

namespace App\Contracts\Repositories;

use App\Models\Task;
use Illuminate\Database\Eloquent\Collection;

interface TaskRepositoryInterface
{
    public function all(): Collection;

    public function find(int $id): ?Task;

    public function create(array $attributes): Task;

    public function update(Task $task, array $attributes): Task;

    public function delete(Task $task): bool;
}
