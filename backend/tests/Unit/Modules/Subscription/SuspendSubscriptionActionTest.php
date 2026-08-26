<?php

declare(strict_types=1);

namespace Tests\Unit\Modules\Subscription;

use App\Modules\Subscription\Application\Actions\SuspendSubscriptionAction;
use App\Modules\Subscription\Domain\Contracts\SubscriptionRepositoryInterface;
use App\Modules\Subscription\Infrastructure\Persistence\Models\Subscription;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Mockery;
use Tests\TestCase;

final class SuspendSubscriptionActionTest extends TestCase
{
    use RefreshDatabase;

    public function test_execute_suspends_subscription_and_persists_it(): void
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

        $action = new SuspendSubscriptionAction(
            $repository
        );

        $result = $action->execute($subscription);

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

        $subscription->refresh();

        $this->assertTrue(
            $subscription->isSuspended()
        );
    }

    protected function tearDown(): void
    {
        Mockery::close();

        parent::tearDown();
    }
}
