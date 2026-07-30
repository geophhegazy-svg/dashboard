<?php

declare(strict_types=1);

namespace App\Core\Workflow\Pipeline;

use App\Core\Workflow\Contracts\WorkflowContextInterface;
use App\Core\Workflow\Contracts\WorkflowResultInterface;
use App\Core\Workflow\Contracts\WorkflowStepInterface;
use App\Core\Workflow\Result\WorkflowResult;
use Closure;

final class WorkflowPipeline
{
    /**
     * @param array<int, WorkflowStepInterface> $steps
     */
    public function __construct(
        private readonly array $steps = [],
    ) {}

    public function process(
        WorkflowContextInterface $context,
    ): WorkflowResultInterface {
        return $this->carry(
            array_reverse($this->steps),
            $context,
        );
    }

    /**
     * @param array<int, WorkflowStepInterface> $steps
     */
    private function carry(
        array $steps,
        WorkflowContextInterface $context,
    ): WorkflowResultInterface {
        $destination = function (
            WorkflowContextInterface $context,
        ): WorkflowResultInterface {
            return new WorkflowResult(
                successful: true,
            );
        };

        foreach ($steps as $step) {
            $next = $destination;

            $destination = function (
                WorkflowContextInterface $context,
            ) use (
                $step,
                $next,
            ): WorkflowResultInterface {
                return $step->handle(
                    $context,
                    $next,
                );
            };
        }

        return $destination($context);
    }
}
