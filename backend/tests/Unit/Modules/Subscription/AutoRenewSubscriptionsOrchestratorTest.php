<?php

declare(strict_types=1);

namespace Tests\Unit\Modules\Subscription;

use App\Core\Workflow\WorkflowEngine;
use App\Modules\Network\Domain\Contracts\MikrotikServiceInterface;
use App\Modules\Subscription\Application\Orchestrators\AutoRenewSubscriptionsOrchestrator;
use App\Modules\Subscription\Application\Workflows\RenewWorkflow;
use App\Modules\Subscription\Domain\Contracts\SubscriptionRepositoryInterface;
use App\Modules\Subscription\Infrastructure\Persistence\Models\Subscription;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Mockery;
use Tests\TestCase;

final class AutoRenewSubscriptionsOrchestratorTest extends TestCase
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
            ->shouldReceive('findEligibleForAutoRenew')
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

        $mikrotik = Mockery::mock(
            MikrotikServiceInterface::class
        );

        $mikrotik
            ->shouldReceive('enableUser')
            ->once()
            ->with($subscription->pppoe_username)
            ->andReturnTrue();

        $this->app->instance(
            MikrotikServiceInterface::class,
            $mikrotik
        );

        $orchestrator = new AutoRenewSubscriptionsOrchestrator(
            $repository,
            $this->app->make(WorkflowEngine::class),
            $this->app->make(RenewWorkflow::class),
        );

        $count = $orchestrator->execute();

        $this->assertSame(
            1,
            $count
        );

        $subscription->refresh();

        $this->assertTrue(
            $subscription->isActive()
        );

        $this->assertGreaterThan(
            now(),
            $subscription->end_date
        );
    }

    public function test_execute_returns_zero_when_no_candidates_exist(): void
    {
        $repository = Mockery::mock(
            SubscriptionRepositoryInterface::class
        );

        $repository
            ->shouldReceive('findEligibleForAutoRenew')
            ->once()
            ->andReturn(
                new Collection()
            );

        $this->app->instance(
            SubscriptionRepositoryInterface::class,
            $repository
        );

        $orchestrator = new AutoRenewSubscriptionsOrchestrator(
            $repository,
            $this->app->make(WorkflowEngine::class),
            $this->app->make(RenewWorkflow::class),
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
