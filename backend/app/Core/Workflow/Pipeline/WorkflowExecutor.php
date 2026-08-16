<?php

declare(strict_types=1);

namespace App\Core\Workflow\Pipeline;

use App\Core\Workflow\AbstractWorkflow;
use App\Core\Workflow\Context\WorkflowContext;
use App\Core\Workflow\Contracts\TransactionManagerInterface;
use App\Core\Workflow\Contracts\WorkflowResultInterface;
use App\Core\Workflow\Steps\TransactionStep;
use App\Core\Workflow\Steps\WorkflowExecutionStep;

final readonly class WorkflowExecutor
{
    public function __construct(
        private TransactionManagerInterface $transactionManager,
    ) {}

    public function execute(
        AbstractWorkflow $workflow,
        mixed ...$arguments,
    ): WorkflowResultInterface {
        $context = new WorkflowContext(
            dto: $arguments,
        );

        $context->set(
            'arguments',
            $arguments,
        );

        $pipeline = new WorkflowPipeline([
            new TransactionStep(
                $this->transactionManager,
            ),
            new WorkflowExecutionStep(
                $workflow,
            ),
        ]);

        return $pipeline->process(
            $context,
        );
    }
}
