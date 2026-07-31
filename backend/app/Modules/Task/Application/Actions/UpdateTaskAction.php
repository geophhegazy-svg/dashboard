<?php

declare(strict_types=1);

namespace App\Modules\Task\Application\Actions;

use App\Models\Task;
use App\Modules\Task\Domain\Contracts\TaskRepositoryInterface;

final readonly class UpdateTaskAction
{
    public function __construct(
        private TaskRepositoryInterface $repository,
    ) {}

    public function execute(
        Task $task,
        array $data,
    ): Task {

        $task->fill($data);

        $this->repository->save($task);

        return $task->refresh();
    }
}
