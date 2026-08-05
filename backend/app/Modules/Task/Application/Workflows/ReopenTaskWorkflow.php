<?php

declare(strict_types=1);

namespace App\Modules\Task\Application\Workflows;

use App\Modules\Task\Infrastructure\Persistence\Models\Task;
use App\Modules\Task\Application\Actions\ReopenTaskAction;

final readonly class ReopenTaskWorkflow
{
    public function __construct(
        private ReopenTaskAction $reopenTask,
    ) {}

    public function execute(
        Task $task,
    ): Task {

        return $this->reopenTask->execute(
            $task,
        );
    }
}
