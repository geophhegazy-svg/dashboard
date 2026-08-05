<?php

declare(strict_types=1);

namespace App\Modules\Task\Application\Workflows;

use App\Modules\Task\Infrastructure\Persistence\Models\Task;
use App\Modules\Task\Application\Actions\DeleteTaskAction;

final readonly class DeleteTaskWorkflow
{
    public function __construct(
        private DeleteTaskAction $deleteTask,
    ) {}

    public function execute(
        Task $task,
    ): bool {

        return $this->deleteTask->execute(
            $task,
        );
    }
}
