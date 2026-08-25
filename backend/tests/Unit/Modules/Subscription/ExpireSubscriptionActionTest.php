<?php

declare(strict_types=1);

namespace Tests\Unit\Modules\Subscription;

use App\Modules\Subscription\Application\Actions\ExpireSubscriptionAction;
use App\Modules\Subscription\Domain\Contracts\SubscriptionRepositoryInterface;
use App\Modules\Subscription\Infrastructure\Persistence\Models\Subscription;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Mockery;
use Tests\TestCase;

final class ExpireSubscriptionActionTest extends TestCase
{
    use RefreshDatabase;

    public function test_execute_expires_subscription_and_persists_it(): void
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
                static function (
                    Subscription $subscription
                ): Subscription {
                    $subscription->save();

                    return $subscription;
                }
            );

        $action = new ExpireSubscriptionAction(
            $repository,
        );

        $result = $action->execute($subscription);

        $this->assertSame(
            $subscription->id,
            $result->id
        );

        $this->assertTrue(
            $result->isExpired()
        );

        $this->assertSame(
            'expired',
            $result->status->value
        );

        $subscription->refresh();

        $this->assertTrue(
            $subscription->isExpired()
        );
    }

    protected function tearDown(): void
    {
        Mockery::close();

        parent::tearDown();
    }
}
