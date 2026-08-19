<?php

declare(strict_types=1);

namespace App\Core\Workflow;

use App\Core\Contracts\RuleInterface;
use App\Core\Contracts\WorkflowInterface;
use App\Core\Workflow\Contracts\WorkflowContextInterface;

abstract class AbstractWorkflow implements WorkflowInterface
{
    final public function execute(
        WorkflowContextInterface $context,
    ): mixed {

        foreach ($this->rules($context) as $rule) {

            if ($rule instanceof RuleInterface) {
                $rule->validate(
                    $context,
                );
            }
        }

        $this->before(
            $context,
        );

        $result = $this->perform(
            $context,
        );

        $this->after(
            $result,
            $context,
        );

        return $result;
    }

    protected function before(
        WorkflowContextInterface $context,
    ): void {}

    abstract protected function perform(
        WorkflowContextInterface $context,
    ): mixed;

    protected function after(
        mixed $result,
        WorkflowContextInterface $context,
    ): void {}

    protected function rules(
        WorkflowContextInterface $context,
    ): iterable {
        return [];
    }
}
