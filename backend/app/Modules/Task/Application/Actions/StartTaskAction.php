<?php

declare(strict_types=1);

namespace App\Modules\Task\Application\Actions;

use App\Models\Task;
use App\Modules\Task\Domain\Contracts\TaskRepositoryInterface;

final readonly class StartTaskAction
{
    public function __construct(
        private TaskRepositoryInterface $repository,
    ) {}

    public function execute(
        Task $task,
    ): Task {

        $task->status = 'in_progress';
        $task->started_at = now();

        $this->repository->save($task);

        return $task->refresh();
    }
}
