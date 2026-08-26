<?php

declare(strict_types=1);

namespace Tests\Unit\Modules\Subscription;

use App\Core\ActionBus\ActionDispatcher;
use App\Core\EventBus\Contracts\EventDispatcherInterface;
use App\Core\Workflow\WorkflowEngine;
use App\Modules\Subscription\Application\Workflows\SuspendWorkflow;
use App\Modules\Subscription\Domain\Contracts\SubscriptionRepositoryInterface;
use App\Modules\Subscription\Domain\Events\SubscriptionSuspended;
use App\Modules\Subscription\Infrastructure\Persistence\Models\Subscription;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Mockery;
use Tests\TestCase;

final class SuspendWorkflowTest extends TestCase
{
    use RefreshDatabase;

    public function test_workflow_dispatches_action_and_emits_event(): void
    {
        $subscription = Subscription::factory()->create([
            'status' => 'active',
        ]);

        $repository = Mockery::mock(
            SubscriptionRepositoryInterface::class
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

        $events = Mockery::mock(
            EventDispatcherInterface::class
        );

        $events
            ->shouldReceive('dispatch')
            ->once()
            ->with(
                Mockery::type(
                    SubscriptionSuspended::class
                )
            );

        $workflow = new SuspendWorkflow(
            $this->app->make(ActionDispatcher::class),
            $events,
        );

        $result = $this->app
            ->make(WorkflowEngine::class)
            ->run(
                $workflow,
                $subscription,
            )
            ->payload();

        $this->assertInstanceOf(
            Subscription::class,
            $result
        );

        $this->assertSame(
            $subscription->id,
            $result->id
        );

        $this->assertTrue(
            $result->isSuspended()
        );
    }

    protected function tearDown(): void
    {
        Mockery::close();

        parent::tearDown();
    }
}
