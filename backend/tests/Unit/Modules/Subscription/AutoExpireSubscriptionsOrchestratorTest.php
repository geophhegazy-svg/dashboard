<?php

declare(strict_types=1);

namespace Tests\Unit\Modules\Subscription;

use App\Core\Workflow\WorkflowEngine;
use App\Modules\Network\Domain\Contracts\MikrotikServiceInterface;
use App\Modules\Subscription\Application\Orchestrators\AutoExpireSubscriptionsOrchestrator;
use App\Modules\Subscription\Application\Workflows\ExpireWorkflow;
use App\Modules\Subscription\Domain\Contracts\SubscriptionRepositoryInterface;
use App\Modules\Subscription\Infrastructure\Persistence\Models\Subscription;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Mockery;
use Tests\TestCase;

final class AutoExpireSubscriptionsOrchestratorTest extends TestCase
{
    use RefreshDatabase;

    public function test_execute_runs_workflow_for_expired_grace_subscriptions(): void
    {
        $subscription = Subscription::factory()->create([
            'status' => 'grace',
            'grace_end_date' => now()->subDay(),
            'pppoe_username' => 'test-expire-user',
        ]);

        $mikrotik = Mockery::mock(
            MikrotikServiceInterface::class
        );

        $mikrotik
            ->shouldReceive('disableUser')
            ->once()
            ->with('test-expire-user')
            ->andReturn(true);

        $this->app->instance(
            MikrotikServiceInterface::class,
            $mikrotik
        );

        $repository = Mockery::mock(
            SubscriptionRepositoryInterface::class
        );

        $repository
            ->shouldReceive('findEligibleForExpiration')
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

        $orchestrator = new AutoExpireSubscriptionsOrchestrator(
            $repository,
            $this->app->make(WorkflowEngine::class),
            $this->app->make(ExpireWorkflow::class),
        );

        $count = $orchestrator->execute();

        $this->assertSame(
            1,
            $count
        );

        $subscription->refresh();

        $this->assertTrue(
            $subscription->isExpired()
        );

        $this->assertSame(
            'expired',
            $subscription->status->value
        );
    }

    public function test_execute_returns_zero_when_no_expiration_candidates_exist(): void
    {
        $repository = Mockery::mock(
            SubscriptionRepositoryInterface::class
        );

        $repository
            ->shouldReceive('findEligibleForExpiration')
            ->once()
            ->andReturn(
                new Collection()
            );

        $this->app->instance(
            SubscriptionRepositoryInterface::class,
            $repository
        );

        $orchestrator = new AutoExpireSubscriptionsOrchestrator(
            $repository,
            $this->app->make(WorkflowEngine::class),
            $this->app->make(ExpireWorkflow::class),
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
