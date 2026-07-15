<?php

declare(strict_types=1);

namespace App\Application\Shared\Workflow;

use App\Application\Shared\Contracts\RuleInterface;
use App\Application\Shared\Contracts\WorkflowInterface;
use Illuminate\Support\Facades\DB;

abstract class AbstractWorkflow implements WorkflowInterface
{
    public function handle(
        mixed ...$arguments
    ): mixed {

        return $this->execute(
            ...$arguments
        );
    }
    
    final public function execute(
        mixed ...$arguments
    ): mixed {

        return DB::transaction(function () use ($arguments): mixed {

            /*
            |--------------------------------------------------------------------------
            | Validation Rules
            |--------------------------------------------------------------------------
            */

            foreach ($this->rules() as $rule) {

                if ($rule instanceof RuleInterface) {
                    $rule->validate(...$arguments);
                }
            }

            /*
            |--------------------------------------------------------------------------
            | Before Hook
            |--------------------------------------------------------------------------
            */

            $this->before(
                ...$arguments
            );

            /*
            |--------------------------------------------------------------------------
            | Execute
            |--------------------------------------------------------------------------
            */

            $result = $this->perform(
                ...$arguments
            );

            /*
            |--------------------------------------------------------------------------
            | After Hook
            |--------------------------------------------------------------------------
            */

            $this->after(
                $result,
                ...$arguments
            );

            return $this->finish(
                $result
            );
        });
    }

    /**
     * @return iterable<RuleInterface>
     */
    protected function rules(): iterable
    {
        return [];
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

    protected function finish(
        mixed $result
    ): mixed {

        return $result;
    }
}
