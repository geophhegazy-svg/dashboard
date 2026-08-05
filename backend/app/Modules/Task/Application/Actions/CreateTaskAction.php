<?php

declare(strict_types=1);

namespace App\Modules\Task\Application\Actions;

use App\Modules\Task\Infrastructure\Persistence\Models\Task;
use App\Modules\Task\Domain\Contracts\TaskRepositoryInterface;

final readonly class CreateTaskAction
{
    public function __construct(
        private TaskRepositoryInterface $repository,
    ) {}

    public function execute(
        Task $task,
    ): Task {

        $this->repository->save($task);

        return $task->refresh();
    }
}
