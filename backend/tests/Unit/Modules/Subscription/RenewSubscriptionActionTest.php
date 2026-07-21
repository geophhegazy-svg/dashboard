<?php

declare(strict_types=1);

namespace Tests\Unit\Modules\Subscription;

use Tests\TestCase;
use Mockery;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Contracts\MikrotikServiceInterface;
use App\Modules\Subscription\Application\Actions\RenewSubscriptionAction;
use App\Modules\Subscription\Domain\Contracts\SubscriptionRepositoryInterface;
use App\Modules\Subscription\Infrastructure\Persistence\Models\Subscription;

class RenewSubscriptionActionTest extends TestCase
{
    use RefreshDatabase;

    public function test_execute_renews_subscription(): void
    {
        $subscription = Subscription::factory()->create([
            'status' => 'expired',
            'end_date' => now()->subDays(10),
            'pppoe_username' => 'test-user',
        ]);

        $oldEndDate = $subscription->end_date->copy();

        $repository = Mockery::mock(
            SubscriptionRepositoryInterface::class
        );

        $repository
            ->shouldReceive('save')
            ->once()
            ->andReturnUsing(
                fn(Subscription $subscription) => $subscription
            );

        $mikrotik = Mockery::mock(
            MikrotikServiceInterface::class
        );

        $mikrotik
            ->shouldReceive('enableUser')
            ->once()
            ->with('test-user');

        $action = new RenewSubscriptionAction(
            $repository,
            $mikrotik
        );

        $result = $action->execute(
            $subscription,
            30
        );

        $this->assertInstanceOf(
            Subscription::class,
            $result
        );

        $this->assertSame(
            $subscription,
            $result
        );

        $this->assertTrue(
            $subscription->end_date->greaterThan($oldEndDate)
        );

    }

    public function test_execute_without_pppoe_user(): void
    {
        $subscription = Subscription::factory()->create([
            'status' => 'expired',
            'end_date' => now()->subDays(10),
            'pppoe_username' => null,
        ]);

        $repository = Mockery::mock(
            SubscriptionRepositoryInterface::class
        );

        $repository
            ->shouldReceive('save')
            ->once()
            ->andReturnUsing(
                fn(Subscription $subscription) => $subscription
            );

        $mikrotik = Mockery::mock(
            MikrotikServiceInterface::class
        );

        $mikrotik
            ->shouldNotReceive('enableUser');

        $action = new RenewSubscriptionAction(
            $repository,
            $mikrotik
        );

        $result = $action->execute(
            $subscription,
            30
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
