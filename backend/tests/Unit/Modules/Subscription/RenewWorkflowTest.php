<?php

declare(strict_types=1);

namespace Tests\Unit\Modules\Subscription;

use Tests\TestCase;
use Mockery;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Modules\Subscription\Application\Actions\RenewSubscriptionAction;
use App\Modules\Subscription\Application\Workflows\RenewWorkflow;
use App\Modules\Subscription\Infrastructure\Persistence\Models\Subscription;

class RenewWorkflowTest extends TestCase
{
    use RefreshDatabase;

    public function test_workflow_executes_action(): void
    {
        $subscription = Subscription::factory()->create();

        $expected = $subscription->fresh();

        $action = Mockery::mock(
            RenewSubscriptionAction::class
        );

        $action
            ->shouldReceive('execute')
            ->once()
            ->with(
                Mockery::type(Subscription::class),
                30
            )
            ->andReturn($expected);

        $workflow = new RenewWorkflow(
            $action
        );

        $result = $workflow->execute(
            $subscription,
            30
        );

        $this->assertInstanceOf(
            Subscription::class,
            $result
        );

        $this->assertEquals(
            $expected->id,
            $result->id
        );
    }

    public function test_workflow_uses_default_days(): void
    {
        $subscription = Subscription::factory()->create();

        $expected = $subscription->fresh();

        $action = Mockery::mock(
            RenewSubscriptionAction::class
        );

        $action
            ->shouldReceive('execute')
            ->once()
            ->with(
                Mockery::type(Subscription::class),
                30
            )
            ->andReturn($expected);

        $workflow = new RenewWorkflow(
            $action
        );

        $result = $workflow->execute(
            $subscription
        );

        $this->assertInstanceOf(
            Subscription::class,
            $result
        );
    }

    protected function tearDown(): void
    {
        Mockery::close();

        parent::tearDown();
    }
}
