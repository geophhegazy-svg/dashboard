<?php

declare(strict_types=1);

namespace Tests\Unit\Modules\Subscription;

use App\Core\Workflow\WorkflowEngine;
use App\Modules\Subscription\Application\Orchestrators\AutoGraceSubscriptionsOrchestrator;
use App\Modules\Subscription\Application\Workflows\EnterGraceWorkflow;
use App\Modules\Subscription\Domain\Contracts\SubscriptionRepositoryInterface;
use App\Modules\Subscription\Infrastructure\Persistence\Models\Subscription;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Mockery;
use Tests\TestCase;

class AutoGraceSubscriptionsOrchestratorTest extends TestCase
{
    use RefreshDatabase;

    public function test_execute_runs_workflow_for_eligible_subscriptions(): void
    {
        $subscription = Subscription::factory()->create([
            'status' => 'active',
            'end_date' => now()->subDay(),
        ]);

        $repository = Mockery::mock(
            SubscriptionRepositoryInterface::class
        );

        $repository
            ->shouldReceive('findEligibleForGracePeriod')
            ->once()
            ->andReturn(
                new Collection([$subscription])
            );

        $repository
            ->shouldReceive('save')
            ->once()
            ->with($subscription)
            ->andReturnUsing(
                static function (
                    Subscription $subscription
                ): Subscription {
                    $subscription->save();

                    return $subscription;
                }
            );

        $this->app->instance(
            SubscriptionRepositoryInterface::class,
            $repository
        );

        $orchestrator = new AutoGraceSubscriptionsOrchestrator(
            $repository,
            $this->app->make(WorkflowEngine::class),
            $this->app->make(EnterGraceWorkflow::class),
        );

        $count = $orchestrator->execute();

        $this->assertSame(1, $count);

        $subscription->refresh();

        $this->assertSame(
            'grace',
            $subscription->status->value
        );

        $this->assertNotNull(
            $subscription->grace_start_date
        );

        $this->assertNotNull(
            $subscription->grace_end_date
        );
    }

    public function test_execute_returns_zero_when_no_subscriptions_are_eligible(): void
    {
        $repository = Mockery::mock(
            SubscriptionRepositoryInterface::class
        );

        $repository
            ->shouldReceive('findEligibleForGracePeriod')
            ->once()
            ->andReturn(
                new Collection()
            );

        $this->app->instance(
            SubscriptionRepositoryInterface::class,
            $repository
        );

        $orchestrator = new AutoGraceSubscriptionsOrchestrator(
            $repository,
            $this->app->make(WorkflowEngine::class),
            $this->app->make(EnterGraceWorkflow::class),
        );

        $this->assertSame(
            0,
            $orchestrator->execute()
        );
    }

    protected function tearDown(): void
    {
        Mockery::close();

        parent::tearDown();
    }
}
