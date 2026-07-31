<?php

declare(strict_types=1);

namespace App\Modules\Task\Domain\Contracts;

use App\Models\Task;
use Illuminate\Database\Eloquent\Collection;

interface TaskRepositoryInterface
{
    public function all(): Collection;

    public function find(int $id): ?Task;

    public function save(Task $task): bool;

    public function delete(Task $task): bool;
}
