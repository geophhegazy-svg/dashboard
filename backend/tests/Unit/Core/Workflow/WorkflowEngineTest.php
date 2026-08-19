<?php

declare(strict_types=1);

namespace Tests\Unit\Core\Workflow;

use App\Core\Workflow\AbstractWorkflow;
use App\Core\Workflow\Contracts\WorkflowContextInterface;
use App\Core\Workflow\Contracts\TransactionManagerInterface;
use App\Core\Workflow\Contracts\WorkflowResultInterface;
use App\Core\Workflow\Pipeline\WorkflowExecutor;
use App\Core\Workflow\WorkflowEngine;
use PHPUnit\Framework\TestCase;

final class WorkflowEngineTest extends TestCase
{
    public function test_engine_executes_workflow_and_wraps_payload(): void
    {
        $workflow = new class extends AbstractWorkflow {
            protected function perform(
                WorkflowContextInterface $context,
            ): mixed {
                $arguments = $context->dto();

                return [
                    'subscription_id' => $arguments[0],
                    'days' => $arguments[1],
                ];
            }
        };

        $transactionManager = $this->createMock(
            TransactionManagerInterface::class,
        );

        $transactionManager
            ->expects($this->once())
            ->method('transaction')
            ->willReturnCallback(
                static fn (callable $callback) => $callback(),
            );

        $engine = new WorkflowEngine(
            new WorkflowExecutor(
                $transactionManager,
            ),
        );

        $result = $engine->run(
            $workflow,
            123,
            30,
        );

        $this->assertInstanceOf(
            WorkflowResultInterface::class,
            $result,
        );

        $this->assertTrue(
            $result->isSuccessful(),
        );

        $this->assertSame(
            [
                'subscription_id' => 123,
                'days' => 30,
            ],
            $result->payload(),
        );
    }

    public function test_engine_executes_workflow_inside_transaction(): void
    {
        $state = new \stdClass();
        $state->insideTransaction = false;

        $workflow = new class($state) extends AbstractWorkflow {
            public function __construct(
                private \stdClass $state,
            ) {}

            protected function perform(
                WorkflowContextInterface $context,
            ): mixed {
                if (! $this->state->insideTransaction) {
                    throw new \RuntimeException(
                        'Workflow executed outside transaction.',
                    );
                }

                return 'completed';
            }
        };

        $transactionManager = $this->createMock(
            TransactionManagerInterface::class,
        );

        $transactionManager
            ->expects($this->once())
            ->method('transaction')
            ->willReturnCallback(
                static function (callable $callback) use ($state) {
                    $state->insideTransaction = true;

                    try {
                        return $callback();
                    } finally {
                        $state->insideTransaction = false;
                    }
                },
            );

        $engine = new WorkflowEngine(
            new WorkflowExecutor(
                $transactionManager,
            ),
        );

        $result = $engine->run(
            $workflow,
        );

        $this->assertTrue(
            $result->isSuccessful(),
        );

        $this->assertSame(
            'completed',
            $result->payload(),
        );

        $this->assertFalse(
            $state->insideTransaction,
        );
    }

    public function test_engine_propagates_workflow_exception_through_transaction(): void
    {
        $workflow = new class extends AbstractWorkflow {
            protected function perform(
                WorkflowContextInterface $context,
            ): mixed {
                throw new \RuntimeException(
                    'Workflow execution failed.'
                );
            }
        };

        $transactionManager = $this->createMock(
            TransactionManagerInterface::class,
        );

        $transactionManager
            ->expects($this->once())
            ->method('transaction')
            ->willReturnCallback(
                static fn (callable $callback) => $callback(),
            );

        $engine = new WorkflowEngine(
            new WorkflowExecutor(
                $transactionManager,
            ),
        );

        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage(
            'Workflow execution failed.'
        );

        $engine->run(
            $workflow,
        );
    }
}
