<?php

declare(strict_types=1);

namespace Tests\Unit\Modules\Network\Listeners;

use App\Exceptions\Network\MikroTikException;

use App\Modules\Network\Application\Listeners\HotspotSubscriptionNetworkLifecycleListener;
use App\Modules\Network\Domain\Contracts\Services\HotspotServiceInterface;
use App\Modules\Subscription\Domain\Events\HotspotSubscriptionActivated;
use App\Modules\Subscription\Domain\Events\HotspotSubscriptionSuspended;
use App\Modules\Subscription\Infrastructure\Persistence\Models\HotspotSubscription;
use Mockery;
use Tests\TestCase;

final class HotspotSubscriptionNetworkLifecycleListenerTest extends TestCase
{
    public function test_activated_hotspot_subscription_enables_network_user(): void
    {
        $hotspot = Mockery::mock(
            HotspotServiceInterface::class
        );

        $hotspot
            ->shouldReceive('findUser')
            ->once()
            ->with('test-user')
            ->andReturn([
                '.id' => '*1',
                'name' => 'test-user',
            ]);

        $hotspot
            ->shouldReceive('enableUser')
            ->once()
            ->with('test-user')
            ->andReturnTrue();

        $subscription = new HotspotSubscription([
            'hotspot_username' => 'test-user',
            'hotspot_password' => 'SecretPass123',
            'mikrotik_profile' => 'default',
        ]);

        $listener = new HotspotSubscriptionNetworkLifecycleListener(
            $hotspot
        );

        $listener->handle(
            new HotspotSubscriptionActivated($subscription)
        );
    }

    public function test_activated_hotspot_subscription_creates_missing_network_user_then_enables_it(): void
    {
        $hotspot = Mockery::mock(
            HotspotServiceInterface::class
        );

        $hotspot
            ->shouldReceive('findUser')
            ->once()
            ->with('new-user')
            ->andReturnNull();

        $hotspot
            ->shouldReceive('createUser')
            ->once()
            ->with(
                'new-user',
                'SecretPass123',
                'default',
            )
            ->andReturnTrue();

        $hotspot
            ->shouldReceive('enableUser')
            ->once()
            ->with('new-user')
            ->andReturnTrue();

        $subscription = new HotspotSubscription([
            'hotspot_username' => 'new-user',
            'hotspot_password' => 'SecretPass123',
            'mikrotik_profile' => 'default',
        ]);

        (new HotspotSubscriptionNetworkLifecycleListener($hotspot))
            ->handle(
                new HotspotSubscriptionActivated($subscription)
            );
    }

    public function test_suspended_hotspot_subscription_disables_network_user(): void
    {
        $hotspot = Mockery::mock(
            HotspotServiceInterface::class
        );

        $hotspot
            ->shouldReceive('disableUser')
            ->once()
            ->with('test-user')
            ->andReturnTrue();

        $subscription = new HotspotSubscription([
            'hotspot_username' => 'test-user',
        ]);

        $listener = new HotspotSubscriptionNetworkLifecycleListener(
            $hotspot
        );

        $listener->handle(
            new HotspotSubscriptionSuspended($subscription)
        );
    }

    public function test_subscription_without_hotspot_username_has_no_network_side_effect(): void
    {
        $hotspot = Mockery::mock(
            HotspotServiceInterface::class
        );

        $hotspot->shouldNotReceive('enableUser');
        $hotspot->shouldNotReceive('disableUser');

        $subscription = new HotspotSubscription([
            'hotspot_username' => null,
        ]);

        $listener = new HotspotSubscriptionNetworkLifecycleListener(
            $hotspot
        );

        $listener->handle(
            new HotspotSubscriptionActivated($subscription)
        );
    }

    public function test_activated_throws_when_enable_fails(): void
    {
        $subscription = new HotspotSubscription([
            'hotspot_username' => 'hotspot-user',
        ]);

        $service = Mockery::mock(HotspotServiceInterface::class);

        $service->shouldReceive('findUser')
            ->once()
            ->with('hotspot-user')
            ->andReturn([
                '.id' => '*1',
                'name' => 'hotspot-user',
            ]);

        $service->shouldReceive('enableUser')
            ->once()
            ->with('hotspot-user')
            ->andReturnFalse();

        $this->expectException(MikroTikException::class);
        $this->expectExceptionMessage(
            'Failed to enable Hotspot user on MikroTik.'
        );

                (new HotspotSubscriptionNetworkLifecycleListener($service))->handle(
            new HotspotSubscriptionActivated($subscription)
        );
    }

    public function test_suspended_throws_when_disable_fails(): void
    {
        $subscription = new HotspotSubscription([
            'hotspot_username' => 'hotspot-user',
        ]);

        $service = Mockery::mock(HotspotServiceInterface::class);

        $service->shouldReceive('disableUser')
            ->once()
            ->with('hotspot-user')
            ->andReturnFalse();

        $this->expectException(MikroTikException::class);
        $this->expectExceptionMessage(
            'Failed to disable Hotspot user on MikroTik.'
        );

                (new HotspotSubscriptionNetworkLifecycleListener($service))->handle(
            new HotspotSubscriptionSuspended($subscription)
        );
    }

}
