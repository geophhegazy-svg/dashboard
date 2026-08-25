<?php

declare(strict_types=1);

namespace Tests\Unit\Modules\Subscription;

use App\Core\ActionBus\ActionDispatcher;
use App\Core\EventBus\Contracts\EventDispatcherInterface;
use App\Core\Workflow\WorkflowEngine;
use App\Modules\Billing\Domain\Contracts\BillingCycleServiceInterface;
use App\Modules\Subscription\Application\Workflows\EnterGraceWorkflow;
use App\Modules\Subscription\Domain\Contracts\SubscriptionRepositoryInterface;
use App\Modules\Subscription\Domain\Events\SubscriptionEnteredGracePeriod;
use App\Modules\Subscription\Infrastructure\Persistence\Models\Subscription;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Mockery;
use Tests\TestCase;

class EnterGraceWorkflowTest extends TestCase
{
    use RefreshDatabase;

    public function test_workflow_dispatches_action_and_emits_event(): void
    {
        $subscription = Subscription::factory()->create([
            'status' => 'active',
            'end_date' => now()->subDay(),
        ]);

        $repository = Mockery::mock(
            SubscriptionRepositoryInterface::class
        );

        $repository
            ->shouldReceive('save')
            ->once()
            ->with($subscription)
            ->andReturnUsing(
                static function (Subscription $subscription): Subscription {
                    $subscription->save();

                    return $subscription->fresh([
                        'customer',
                        'package',
                    ]);
                }
            );

        $this->app->instance(
            SubscriptionRepositoryInterface::class,
            $repository
        );

        $billingCycle = Mockery::mock(
            BillingCycleServiceInterface::class
        );

        $billingCycle
            ->shouldReceive('calculateGraceDate')
            ->once()
            ->with(
                Mockery::type(\Carbon\Carbon::class),
                Mockery::type(
                    \App\Modules\Package\Infrastructure\Persistence\Models\Package::class
                ),
            )
            ->andReturn(
                now()->addDays(5)
            );

        $this->app->instance(
            BillingCycleServiceInterface::class,
            $billingCycle
        );

        $events = Mockery::mock(
            EventDispatcherInterface::class
        );

        $events
            ->shouldReceive('dispatch')
            ->once()
            ->with(
                Mockery::type(
                    SubscriptionEnteredGracePeriod::class
                )
            );

        $workflow = new EnterGraceWorkflow(
            $this->app->make(ActionDispatcher::class),
            $events,
        );

        $result = $this->app
            ->make(WorkflowEngine::class)
            ->run(
                $workflow,
                $subscription,
            );

        $result = $result->payload();

        $this->assertInstanceOf(
            Subscription::class,
            $result
        );

        $this->assertSame(
            $subscription->id,
            $result->id
        );

        $this->assertTrue(
            $result->isGrace());

        $this->assertNotNull(
            $result->grace_start_date
        );

        $this->assertNotNull(
            $result->grace_end_date
        );
    }

    protected function tearDown(): void
    {
        Mockery::close();

        parent::tearDown();
    }
}
