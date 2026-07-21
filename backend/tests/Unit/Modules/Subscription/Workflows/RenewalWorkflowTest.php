<?php

declare(strict_types=1);

namespace Tests\Unit\Modules\Subscription\Workflows;

use Mockery;
use Tests\TestCase;
use App\Core\DTO\RenewalResult;
use Illuminate\Database\Eloquent\Collection;
use App\Modules\Subscription\Application\Actions\RenewSubscriptionAction;
use App\Modules\Subscription\Application\Workflows\RenewalWorkflow;
use App\Modules\Subscription\Domain\Contracts\SubscriptionRepositoryInterface;
use App\Modules\Subscription\Infrastructure\Persistence\Models\Subscription;

class RenewalWorkflowTest extends TestCase
{
    public function test_returns_empty_result_when_no_subscriptions(): void
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

        $action = Mockery::mock(
            RenewSubscriptionAction::class
        );

        $workflow = new RenewalWorkflow(
            $repository,
            $action
        );

        $result = $workflow->run();

        $this->assertInstanceOf(
            RenewalResult::class,
            $result
        );

        $this->assertSame(
            0,
            $result->processed
        );

        $this->assertSame(
            0,
            $result->renewed
        );

        $this->assertSame(
            0,
            $result->failed
        );
    }

    public function test_renews_single_subscription(): void
    {
        $subscription = new Subscription();

        $subscription->id = 1;

        $repository = Mockery::mock(
            SubscriptionRepositoryInterface::class
        );

        $repository
            ->shouldReceive('findEligibleForAutoRenew')
            ->once()
            ->andReturn(
                new Collection([$subscription])
            );

        $action = Mockery::mock(
            RenewSubscriptionAction::class
        );

        $action
            ->shouldReceive('execute')
            ->once()
            ->with(
                $subscription,
                30
            );

        $workflow = new RenewalWorkflow(
            $repository,
            $action
        );

        $result = $workflow->run();

        $this->assertSame(
            1,
            $result->processed
        );

        $this->assertSame(
            1,
            $result->renewed
        );

        $this->assertSame(
            0,
            $result->failed
        );
    }

    public function test_continues_when_one_subscription_fails(): void
    {
        $first = new Subscription();
        $first->id = 1;

        $second = new Subscription();
        $second->id = 2;

        $repository = Mockery::mock(
            SubscriptionRepositoryInterface::class
        );

        $repository
            ->shouldReceive('findEligibleForAutoRenew')
            ->once()
            ->andReturn(
                new Collection([
                    $first,
                    $second,
                ])
            );

        $action = Mockery::mock(
            RenewSubscriptionAction::class
        );

        $action
            ->shouldReceive('execute')
            ->once()
            ->with(
                $first,
                30
            )
            ->andThrow(
                new \RuntimeException('Renew failed')
            );

        $action
            ->shouldReceive('execute')
            ->once()
            ->with(
                $second,
                30
            );

        $workflow = new RenewalWorkflow(
            $repository,
            $action
        );

        $result = $workflow->run();

        $this->assertSame(
            2,
            $result->processed
        );

        $this->assertSame(
            1,
            $result->renewed
        );

        $this->assertSame(
            1,
            $result->failed
        );

        $this->assertCount(
            1,
            $result->errors
        );
    }

    protected function tearDown(): void
    {
        Mockery::close();

        parent::tearDown();
    }
}
