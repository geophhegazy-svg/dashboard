<?php

declare(strict_types=1);

namespace Tests\Unit\Modules\Subscription;

use Mockery;
use Carbon\Carbon;
use Tests\TestCase;
use App\Core\Workflow\WorkflowEngine;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Core\ActionBus\ActionDispatcher;
use App\Core\EventBus\Contracts\EventDispatcherInterface;
use App\Modules\Subscription\Application\Workflows\RenewWorkflow;
use App\Modules\Subscription\Domain\Contracts\SubscriptionRepositoryInterface;
use App\Modules\Subscription\Infrastructure\Persistence\Models\Subscription;

class RenewWorkflowTest extends TestCase
{
    use RefreshDatabase;

    public function test_workflow_dispatches_action(): void
    {
        $subscription = Subscription::factory()->create();

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

        $events = Mockery::mock(
            EventDispatcherInterface::class
        );

        $events
            ->shouldReceive('dispatch')
            ->once()
            ->with(
                Mockery::type(
                    \App\Modules\Subscription\Domain\Events\SubscriptionRenewed::class
                )
            );

        $workflow = new RenewWorkflow(
            $this->app->make(ActionDispatcher::class),
            $events
        );

        $result = $this->app
            ->make(WorkflowEngine::class)
            ->run(
                $workflow,
                $subscription,
                30,
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
            $result->isActive()
        );

        $this->assertNotNull(
            $result->end_date
        );
    }

    public function test_workflow_uses_default_days(): void
    {
        $subscription = Subscription::factory()->create([
            'end_date' => null,
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

        $events = Mockery::mock(
            EventDispatcherInterface::class
        );

        $events
            ->shouldReceive('dispatch')
            ->once()
            ->with(
                Mockery::type(
                    \App\Modules\Subscription\Domain\Events\SubscriptionRenewed::class
                )
            );

        $workflow = new RenewWorkflow(
            $this->app->make(ActionDispatcher::class),
            $events
        );

        $before = Carbon::parse('2026-01-01');

        Carbon::setTestNow($before);

        try {
            $result = $this->app
                ->make(WorkflowEngine::class)
                ->run(
                    $workflow,
                    $subscription,
                );

            $result = $result->payload();
        } finally {
            Carbon::setTestNow();
        }

        $this->assertInstanceOf(
            Subscription::class,
            $result
        );

        $this->assertSame(
            $subscription->id,
            $result->id
        );

        $this->assertNotNull(
            $result->end_date
        );

        $this->assertSame(
            '2026-01-31',
            $result->end_date->format('Y-m-d')
        );
    }

    public function test_workflow_rolls_back_subscription_when_after_event_fails(): void
    {
        $subscription = Subscription::factory()->create([
            'status' => \App\Modules\Subscription\Domain\Enums\SubscriptionStatus::ACTIVE,
            'end_date' => Carbon::parse('2026-01-01'),
        ]);

        $originalEndDate = $subscription->end_date->format('Y-m-d');

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

        $events = Mockery::mock(
            EventDispatcherInterface::class
        );

        $events
            ->shouldReceive('dispatch')
            ->once()
            ->andThrow(
                new \RuntimeException(
                    'Renewal event failed.'
                )
            );

        $workflow = new RenewWorkflow(
            $this->app->make(ActionDispatcher::class),
            $events
        );

        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage(
            'Renewal event failed.'
        );

        try {
            $this->app
                ->make(WorkflowEngine::class)
                ->run(
                    $workflow,
                    $subscription,
                    30,
                );
        } finally {
            $subscription->refresh();

            $this->assertSame(
                \App\Modules\Subscription\Domain\Enums\SubscriptionStatus::ACTIVE,
                $subscription->status,
            );

            $this->assertSame(
                $originalEndDate,
                $subscription->end_date->format('Y-m-d'),
            );
        }
    }

    protected function tearDown(): void
    {
        Mockery::close();

        parent::tearDown();
    }
}
