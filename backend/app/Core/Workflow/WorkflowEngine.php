<?php

declare(strict_types=1);

namespace App\Core\Workflow;

use App\Core\Workflow\Contracts\WorkflowResultInterface;
use App\Core\Workflow\Pipeline\WorkflowExecutor;

final readonly class WorkflowEngine
{
    public function __construct(
        private WorkflowExecutor $executor,
    ) {}

    public function run(
        AbstractWorkflow $workflow,
        mixed ...$arguments,
    ): WorkflowResultInterface {
        return $this->executor->execute(
            $workflow,
            ...$arguments,
        );
    }
}
