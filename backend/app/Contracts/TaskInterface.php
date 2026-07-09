<?php

declare(strict_types=1);

namespace App\Contracts;

use App\Data\Task\TaskData;
use App\Models\Task;

interface TaskInterface
{
    public function create(TaskData $data): Task;

    public function update(Task $task, TaskData $data): Task;

    public function complete(Task $task): Task;

    public function cancel(Task $task): Task;

    public function reopen(Task $task): Task;

    public function assign(Task $task, int $userId): Task;
}
