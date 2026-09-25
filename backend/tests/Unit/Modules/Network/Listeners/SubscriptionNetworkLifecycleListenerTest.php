<?php

declare(strict_types=1);

namespace Tests\Unit\Modules\Network\Listeners;

use App\Exceptions\Network\MikroTikException;
use App\Modules\Network\Application\Contracts\NetworkDeviceResolverInterface;
use App\Modules\Network\Application\Contracts\NetworkManagerInterface;
use App\Modules\Network\Application\Listeners\SubscriptionNetworkLifecycleListener;
use App\Modules\Network\Domain\Contracts\MikrotikServiceInterface;
use App\Modules\Network\Infrastructure\Persistence\Models\NetworkDevice;
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
    private function subscription(): Subscription
    {
        $subscription = new Subscription([
            'tenant_id' => 1,
            'pppoe_username' => 'test-user',
        ]);

        $subscription->id = 10;

        return $subscription;
    }

    private function device(): NetworkDevice
    {
        $device = new NetworkDevice([
            'tenant_id' => null,
            'name' => 'MikroTik Test',
            'ip_address' => '2.2.2.2',
            'type' => 'mikrotik',
            'status' => 'active',
        ]);

        $device->id = 1;

        return $device;
    }

    private function listener(
        MikrotikServiceInterface $mikrotik,
        NetworkDeviceResolverInterface $resolver,
        NetworkManagerInterface $manager,
    ): SubscriptionNetworkLifecycleListener {
        return new SubscriptionNetworkLifecycleListener(
            $mikrotik,
            $resolver,
            $manager,
        );
    }

    private function expectDeviceResolution(
        NetworkDeviceResolverInterface $resolver,
        Subscription $subscription,
        NetworkDevice $device,
    ): void {
        $resolver
            ->shouldReceive('resolveForSubscription')
            ->once()
            ->with($subscription)
            ->andReturn($device);
    }

    private function expectConnection(
        NetworkManagerInterface $manager,
        NetworkDevice $device,
    ): void {
        $manager
            ->shouldReceive('connect')
            ->once()
            ->with($device->id)
            ->andReturnTrue();
    }

    public function test_activated_subscription_connects_then_enables_mikrotik_user(): void
    {
        $mikrotik = Mockery::mock(MikrotikServiceInterface::class);
        $resolver = Mockery::mock(NetworkDeviceResolverInterface::class);
        $manager = Mockery::mock(NetworkManagerInterface::class);

        $subscription = $this->subscription();
        $device = $this->device();

        $this->expectDeviceResolution($resolver, $subscription, $device);
        $this->expectConnection($manager, $device);

        $mikrotik
            ->shouldReceive('enableUser')
            ->once()
            ->with('test-user')
            ->andReturnTrue();

        $this->listener($mikrotik, $resolver, $manager)
            ->handle(new SubscriptionActivated($subscription));
    }

    public function test_restored_subscription_connects_then_enables_mikrotik_user(): void
    {
        $mikrotik = Mockery::mock(MikrotikServiceInterface::class);
        $resolver = Mockery::mock(NetworkDeviceResolverInterface::class);
        $manager = Mockery::mock(NetworkManagerInterface::class);

        $subscription = $this->subscription();
        $device = $this->device();

        $this->expectDeviceResolution($resolver, $subscription, $device);
        $this->expectConnection($manager, $device);

        $mikrotik
            ->shouldReceive('enableUser')
            ->once()
            ->with('test-user')
            ->andReturnTrue();

        $this->listener($mikrotik, $resolver, $manager)
            ->handle(new SubscriptionRestored($subscription));
    }

    public function test_renewed_subscription_connects_then_enables_mikrotik_user(): void
    {
        $mikrotik = Mockery::mock(MikrotikServiceInterface::class);
        $resolver = Mockery::mock(NetworkDeviceResolverInterface::class);
        $manager = Mockery::mock(NetworkManagerInterface::class);

        $subscription = $this->subscription();
        $device = $this->device();

        $this->expectDeviceResolution($resolver, $subscription, $device);
        $this->expectConnection($manager, $device);

        $mikrotik
            ->shouldReceive('enableUser')
            ->once()
            ->with('test-user')
            ->andReturnTrue();

        $this->listener($mikrotik, $resolver, $manager)
            ->handle(new SubscriptionRenewed($subscription, 'renewal-key'));
    }

    public function test_suspended_subscription_connects_then_disables_mikrotik_user(): void
    {
        $mikrotik = Mockery::mock(MikrotikServiceInterface::class);
        $resolver = Mockery::mock(NetworkDeviceResolverInterface::class);
        $manager = Mockery::mock(NetworkManagerInterface::class);

        $subscription = $this->subscription();
        $device = $this->device();

        $this->expectDeviceResolution($resolver, $subscription, $device);
        $this->expectConnection($manager, $device);

        $mikrotik
            ->shouldReceive('disableUser')
            ->once()
            ->with('test-user')
            ->andReturnTrue();

        $this->listener($mikrotik, $resolver, $manager)
            ->handle(new SubscriptionSuspended($subscription));
    }

    public function test_expired_subscription_succeeds_when_pppoe_user_is_already_absent(): void
    {
        $mikrotik = Mockery::mock(MikrotikServiceInterface::class);
        $resolver = Mockery::mock(NetworkDeviceResolverInterface::class);
        $manager = Mockery::mock(NetworkManagerInterface::class);

        $subscription = $this->subscription();
        $device = $this->device();

        $this->expectDeviceResolution($resolver, $subscription, $device);
        $this->expectConnection($manager, $device);

        $mikrotik
            ->shouldReceive('disableUser')
            ->once()
            ->with('test-user')
            ->andThrow(
                \App\Exceptions\Network\ResourceNotFoundException::missing(
                    'pppoe-user',
                    ['username' => 'test-user']
                )
            );

        $mikrotik
            ->shouldNotReceive('disconnectUser');

        $this->listener($mikrotik, $resolver, $manager)
            ->handle(new SubscriptionExpired($subscription));

        $this->addToAssertionCount(1);
    }
    public function test_expired_subscription_connects_then_disables_and_disconnects(): void
    {
        $mikrotik = Mockery::mock(MikrotikServiceInterface::class);
        $resolver = Mockery::mock(NetworkDeviceResolverInterface::class);
        $manager = Mockery::mock(NetworkManagerInterface::class);

        $subscription = $this->subscription();
        $device = $this->device();

        $this->expectDeviceResolution($resolver, $subscription, $device);
        $this->expectConnection($manager, $device);

        $mikrotik
            ->shouldReceive('disableUser')
            ->once()
            ->with('test-user')
            ->andReturnTrue();

        $mikrotik
            ->shouldReceive('disconnectUser')
            ->once()
            ->with('test-user')
            ->andReturnTrue();

        $this->listener($mikrotik, $resolver, $manager)
            ->handle(new SubscriptionExpired($subscription));
    }

    public function test_subscription_without_pppoe_username_has_no_network_side_effect(): void
    {
        $mikrotik = Mockery::mock(MikrotikServiceInterface::class);
        $resolver = Mockery::mock(NetworkDeviceResolverInterface::class);
        $manager = Mockery::mock(NetworkManagerInterface::class);

        $subscription = new Subscription([
            'pppoe_username' => null,
        ]);

        $mikrotik->shouldNotReceive('enableUser');
        $mikrotik->shouldNotReceive('disableUser');
        $mikrotik->shouldNotReceive('disconnectUser');
        $resolver->shouldNotReceive('resolveForSubscription');
        $manager->shouldNotReceive('connect');

        $this->listener($mikrotik, $resolver, $manager)
            ->handle(new SubscriptionActivated($subscription));
    }

    public function test_missing_device_throws_mikrotik_exception(): void
    {
        $mikrotik = Mockery::mock(MikrotikServiceInterface::class);
        $resolver = Mockery::mock(NetworkDeviceResolverInterface::class);
        $manager = Mockery::mock(NetworkManagerInterface::class);

        $subscription = $this->subscription();

        $resolver
            ->shouldReceive('resolveForSubscription')
            ->once()
            ->with($subscription)
            ->andReturnNull();

        $manager->shouldNotReceive('connect');
        $mikrotik->shouldNotReceive('enableUser');

        $this->expectException(MikroTikException::class);
        $this->expectExceptionMessage(
            'No active MikroTik network device is configured'
        );

        $this->listener($mikrotik, $resolver, $manager)
            ->handle(new SubscriptionActivated($subscription));
    }

    public function test_connection_failure_throws_mikrotik_exception(): void
    {
        $mikrotik = Mockery::mock(MikrotikServiceInterface::class);
        $resolver = Mockery::mock(NetworkDeviceResolverInterface::class);
        $manager = Mockery::mock(NetworkManagerInterface::class);

        $subscription = $this->subscription();
        $device = $this->device();

        $this->expectDeviceResolution($resolver, $subscription, $device);

        $manager
            ->shouldReceive('connect')
            ->once()
            ->with($device->id)
            ->andReturnFalse();

        $mikrotik->shouldNotReceive('enableUser');

        $this->expectException(MikroTikException::class);
        $this->expectExceptionMessage(
            'Failed to connect to MikroTik network device'
        );

        $this->listener($mikrotik, $resolver, $manager)
            ->handle(new SubscriptionActivated($subscription));
    }

    public function test_enable_failure_still_throws_mikrotik_exception(): void
    {
        $mikrotik = Mockery::mock(MikrotikServiceInterface::class);
        $resolver = Mockery::mock(NetworkDeviceResolverInterface::class);
        $manager = Mockery::mock(NetworkManagerInterface::class);

        $subscription = $this->subscription();
        $device = $this->device();

        $this->expectDeviceResolution($resolver, $subscription, $device);
        $this->expectConnection($manager, $device);

        $mikrotik
            ->shouldReceive('enableUser')
            ->once()
            ->with('test-user')
            ->andReturnFalse();

        $this->expectException(MikroTikException::class);
        $this->expectExceptionMessage(
            'Failed to enable PPPoE user on MikroTik.'
        );

        $this->listener($mikrotik, $resolver, $manager)
            ->handle(new SubscriptionActivated($subscription));
    }

    public function test_suspend_failure_still_throws_mikrotik_exception(): void
    {
        $mikrotik = Mockery::mock(MikrotikServiceInterface::class);
        $resolver = Mockery::mock(NetworkDeviceResolverInterface::class);
        $manager = Mockery::mock(NetworkManagerInterface::class);

        $subscription = $this->subscription();
        $device = $this->device();

        $this->expectDeviceResolution($resolver, $subscription, $device);
        $this->expectConnection($manager, $device);

        $mikrotik
            ->shouldReceive('disableUser')
            ->once()
            ->with('test-user')
            ->andReturnFalse();

        $this->expectException(MikroTikException::class);
        $this->expectExceptionMessage(
            'Failed to disable PPPoE user on MikroTik.'
        );

        $this->listener($mikrotik, $resolver, $manager)
            ->handle(new SubscriptionSuspended($subscription));
    }

    public function test_expired_disconnect_failure_still_throws_mikrotik_exception(): void
    {
        $mikrotik = Mockery::mock(MikrotikServiceInterface::class);
        $resolver = Mockery::mock(NetworkDeviceResolverInterface::class);
        $manager = Mockery::mock(NetworkManagerInterface::class);

        $subscription = $this->subscription();
        $device = $this->device();

        $this->expectDeviceResolution($resolver, $subscription, $device);
        $this->expectConnection($manager, $device);

        $mikrotik
            ->shouldReceive('disableUser')
            ->once()
            ->with('test-user')
            ->andReturnTrue();

        $mikrotik
            ->shouldReceive('disconnectUser')
            ->once()
            ->with('test-user')
            ->andReturnFalse();

        $this->expectException(MikroTikException::class);
        $this->expectExceptionMessage(
            'Failed to disconnect expired PPPoE user'
        );

        $this->listener($mikrotik, $resolver, $manager)
            ->handle(new SubscriptionExpired($subscription));
    }
}
