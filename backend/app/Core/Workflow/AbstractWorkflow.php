<?php

declare(strict_types=1);

namespace App\Core\Workflow;

use App\Core\Contracts\RuleInterface;
use App\Core\Contracts\WorkflowInterface;


abstract class AbstractWorkflow implements WorkflowInterface
{
    

    public function execute(
        mixed ...$arguments
    ): mixed {

        foreach ($this->rules() as $rule) {

            if ($rule instanceof RuleInterface) {
                $rule->validate(...$arguments);
            }
        }

        $this->before(...$arguments);

        $result = $this->perform(...$arguments);

        $this->after(
            $result,
            ...$arguments
        );

        return $result;
    }

    protected function before(
        mixed ...$arguments
    ): void {}

    abstract protected function perform(
        mixed ...$arguments
    ): mixed;

    protected function after(
        mixed $result,
        mixed ...$arguments
    ): void {}

    protected function rules(): iterable
    {
        return [];
    }
}
