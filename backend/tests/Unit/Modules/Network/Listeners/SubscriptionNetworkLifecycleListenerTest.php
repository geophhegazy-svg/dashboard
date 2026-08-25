<?php

declare(strict_types=1);

namespace Tests\Unit\Modules\Network\Listeners;

use App\Modules\Network\Application\Listeners\SubscriptionNetworkLifecycleListener;
use App\Modules\Network\Domain\Contracts\MikrotikServiceInterface;
use App\Modules\Subscription\Domain\Events\SubscriptionActivated;
use App\Modules\Subscription\Domain\Events\SubscriptionExpired;
use App\Modules\Subscription\Domain\Events\SubscriptionRenewed;
use App\Modules\Subscription\Domain\Events\SubscriptionRestored;
use App\Modules\Subscription\Domain\Events\SubscriptionSuspended;
use App\Modules\Subscription\Infrastructure\Persistence\Models\Subscription;
use Mockery;
use Tests\TestCase;

final class SubscriptionNetworkLifecycleListenerTest extends TestCase
{
    public function test_activated_subscription_enables_mikrotik_user(): void
    {
        $mikrotik = Mockery::mock(MikrotikServiceInterface::class);

        $mikrotik
            ->shouldReceive('enableUser')
            ->once()
            ->with('test-user')
            ->andReturnTrue();

        $subscription = new Subscription();
        $subscription->pppoe_username = 'test-user';

        $listener = new SubscriptionNetworkLifecycleListener($mikrotik);

        $listener->handle(new SubscriptionActivated($subscription));
    }

    public function test_restored_subscription_enables_mikrotik_user(): void
    {
        $mikrotik = Mockery::mock(MikrotikServiceInterface::class);

        $mikrotik
            ->shouldReceive('enableUser')
            ->once()
            ->with('test-user')
            ->andReturnTrue();

        $subscription = new Subscription();
        $subscription->pppoe_username = 'test-user';

        $listener = new SubscriptionNetworkLifecycleListener($mikrotik);

        $listener->handle(new SubscriptionRestored($subscription));
    }

    public function test_renewed_subscription_enables_mikrotik_user(): void
    {
        $mikrotik = Mockery::mock(MikrotikServiceInterface::class);

        $mikrotik
            ->shouldReceive('enableUser')
            ->once()
            ->with('test-user')
            ->andReturnTrue();

        $subscription = new Subscription();
        $subscription->pppoe_username = 'test-user';

        $listener = new SubscriptionNetworkLifecycleListener($mikrotik);

        $listener->handle(
            new SubscriptionRenewed($subscription, 'renewal-key')
        );
    }

    public function test_suspended_subscription_disables_mikrotik_user(): void
    {
        $mikrotik = Mockery::mock(MikrotikServiceInterface::class);

        $mikrotik
            ->shouldReceive('disableUser')
            ->once()
            ->with('test-user')
            ->andReturnTrue();

        $subscription = new Subscription();
        $subscription->pppoe_username = 'test-user';

        $listener = new SubscriptionNetworkLifecycleListener($mikrotik);

        $listener->handle(new SubscriptionSuspended($subscription));
    }

    public function test_expired_subscription_disables_mikrotik_user(): void
    {
        $mikrotik = Mockery::mock(MikrotikServiceInterface::class);

        $mikrotik
            ->shouldReceive('disableUser')
            ->once()
            ->with('test-user')
            ->andReturnTrue();

        $subscription = new Subscription();
        $subscription->pppoe_username = 'test-user';

        $listener = new SubscriptionNetworkLifecycleListener($mikrotik);

        $listener->handle(new SubscriptionExpired($subscription));
    }

    public function test_subscription_without_pppoe_username_has_no_network_side_effect(): void
    {
        $mikrotik = Mockery::mock(MikrotikServiceInterface::class);

        $mikrotik
            ->shouldNotReceive('enableUser');

        $mikrotik
            ->shouldNotReceive('disableUser');

        $subscription = new Subscription();
        $subscription->pppoe_username = null;

        $listener = new SubscriptionNetworkLifecycleListener($mikrotik);

        $listener->handle(new SubscriptionActivated($subscription));
    }
}
