<?php

declare(strict_types=1);

namespace Tests\Feature\Core\Workflow;

use App\Core\Workflow\Contracts\TransactionManagerInterface;
use App\Core\Workflow\WorkflowEngine;
use App\Infrastructure\Laravel\Database\LaravelTransactionManager;
use Tests\TestCase;

final class KernelWorkflowBindingTest extends TestCase
{
    public function test_transaction_manager_is_bound_to_laravel_implementation(): void
    {
        $manager = $this->app->make(
            TransactionManagerInterface::class,
        );

        self::assertInstanceOf(
            LaravelTransactionManager::class,
            $manager,
        );
    }

    public function test_workflow_engine_is_registered_as_singleton(): void
    {
        $first = $this->app->make(
            WorkflowEngine::class,
        );

        $second = $this->app->make(
            WorkflowEngine::class,
        );

        self::assertSame(
            $first,
            $second,
        );
    }
}
