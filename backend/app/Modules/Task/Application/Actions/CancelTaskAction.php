<?php

declare(strict_types=1);

namespace App\Modules\Task\Application\Actions;

use App\Modules\Task\Infrastructure\Persistence\Models\Task;
use App\Modules\Task\Domain\Contracts\TaskRepositoryInterface;

final readonly class CancelTaskAction
{
    public function __construct(
        private TaskRepositoryInterface $repository,
    ) {}

    public function execute(
        Task $task,
    ): Task {

        $task->status = 'cancelled';
        $task->cancelled_at = now();

        $this->repository->save($task);

        return $task->refresh();
    }
}
