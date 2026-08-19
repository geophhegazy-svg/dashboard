<?php

declare(strict_types=1);

namespace App\Core\Workflow\Steps;

use App\Core\Workflow\AbstractWorkflow;
use App\Core\Workflow\Contracts\WorkflowContextInterface;
use App\Core\Workflow\Contracts\WorkflowResultInterface;
use App\Core\Workflow\Contracts\WorkflowStepInterface;
use App\Core\Workflow\Result\WorkflowResult;
use Closure;

final readonly class WorkflowExecutionStep implements WorkflowStepInterface
{
    public function __construct(
        private AbstractWorkflow $workflow,
    ) {}

    public function handle(
        WorkflowContextInterface $context,
        Closure $next,
    ): WorkflowResultInterface {

        $payload = $this->workflow->execute(
            $context,
        );

        $result = new WorkflowResult(
            successful: true,
            payload: $payload,
        );

        return $next(
            $context->set(
                'result',
                $result,
            ),
        );
    }
}
