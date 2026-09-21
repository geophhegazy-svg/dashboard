<?php

declare(strict_types=1);

namespace Tests\Unit\Modules\Subscription;

use App\Core\Tenancy\Contracts\TenantContextInterface;
use App\Modules\Customer\Infrastructure\Persistence\Models\Customer;
use App\Core\EventBus\Contracts\EventDispatcherInterface;
use App\Modules\Subscription\Domain\Events\HotspotSubscriptionActivated;
use App\Modules\Subscription\Domain\Events\HotspotSubscriptionSuspended;
use Tests\Fakes\Core\FakeEventDispatcher;
use App\Modules\Subscription\Application\Actions\ActivateHotspotSubscriptionAction;
use App\Modules\Subscription\Application\Actions\CreateHotspotSubscriptionAction;
use App\Modules\Subscription\Application\Actions\DeleteHotspotSubscriptionAction;
use App\Modules\Subscription\Application\Actions\SuspendHotspotSubscriptionAction;
use App\Modules\Subscription\Domain\Contracts\HotspotSubscriptionRepositoryInterface;
use App\Modules\Subscription\Infrastructure\Persistence\Models\HotspotSubscription;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Mockery;
use Tests\TestCase;

final class HotspotSubscriptionActionsTest extends TestCase
{
    use RefreshDatabase;

    public function test_create_action_persists_subscription_data(): void
    {
        $customer = Customer::factory()->create();

        $repository = Mockery::mock(
            HotspotSubscriptionRepositoryInterface::class
        );

        $repository
            ->shouldReceive('create')
            ->once()
            ->with(Mockery::on(
                static function (array $data) use ($customer): bool {
                    return $data['customer_id'] === $customer->id
                        && $data['hotspot_username'] === 'hs' . $customer->id
                        && isset($data['hotspot_password'])
                        && $data['mikrotik_profile'] === 'default';
                }
            ))
            ->andReturnUsing(
                static fn (array $data): HotspotSubscription =>
                    new HotspotSubscription($data)
            );

        $tenantContext = Mockery::mock(
            TenantContextInterface::class
        );

        $tenantContext
            ->shouldReceive('isGlobal')
            ->once()
            ->andReturnFalse();

        $tenantContext
            ->shouldReceive('tenantId')
            ->once()
            ->andReturn($customer->tenant_id);

        $action = new CreateHotspotSubscriptionAction(
            $repository,
            $tenantContext,
        );

        $result = $action->execute([
            'tenant_id' => $customer->tenant_id,
            'customer_id' => $customer->id,
            'package_id' => 1,
            'start_date' => now()->toDateString(),
            'end_date' => now()->addMonth()->toDateString(),
            'monthly_price' => 100,
        ]);

        $this->assertInstanceOf(
            HotspotSubscription::class,
            $result
        );

        $this->assertSame(
            'hs' . $customer->id,
            $result->hotspot_username
        );
    }

    public function test_activate_action_persists_active_status(): void
    {
        $events = new FakeEventDispatcher();

        $subscription = new HotspotSubscription([
            'hotspot_username' => 'test-user',
            'status' => 'suspended',
        ]);

        $repository = Mockery::mock(
            HotspotSubscriptionRepositoryInterface::class
        );

        $repository
            ->shouldReceive('update')
            ->once()
            ->with(
                $subscription,
                ['status' => 'active']
            )
            ->andReturnUsing(
                static function (
                    HotspotSubscription $subscription,
                    array $attributes
                ): HotspotSubscription {
                    $subscription->fill($attributes);

                    return $subscription;
                }
            );

        $action = new ActivateHotspotSubscriptionAction(
            $repository,
            $events,
        );

        $result = $action->execute(
            $subscription
        );

        $this->assertSame(
            'active',
            $result->status
        );

        $this->assertTrue(
            $events->has(
                HotspotSubscriptionActivated::class
            )
        );
    }

    public function test_suspend_action_persists_suspended_status(): void
    {
        $events = new FakeEventDispatcher();

        $subscription = new HotspotSubscription([
            'hotspot_username' => 'test-user',
            'status' => 'active',
        ]);

        $repository = Mockery::mock(
            HotspotSubscriptionRepositoryInterface::class
        );

        $repository
            ->shouldReceive('update')
            ->once()
            ->with(
                $subscription,
                ['status' => 'suspended']
            )
            ->andReturnUsing(
                static function (
                    HotspotSubscription $subscription,
                    array $attributes
                ): HotspotSubscription {
                    $subscription->fill($attributes);

                    return $subscription;
                }
            );

        $action = new SuspendHotspotSubscriptionAction(
            $repository,
            $events,
        );

        $result = $action->execute(
            $subscription
        );

        $this->assertSame(
            'suspended',
            $result->status
        );

        $this->assertTrue(
            $events->has(
                HotspotSubscriptionSuspended::class
            )
        );
    }

    public function test_delete_action_deletes_database_subscription(): void
    {
        $subscription = new HotspotSubscription([
            'hotspot_username' => 'test-user',
        ]);

        $repository = Mockery::mock(
            HotspotSubscriptionRepositoryInterface::class
        );

        $repository
            ->shouldReceive('delete')
            ->once()
            ->with($subscription)
            ->andReturnTrue();

        $action = new DeleteHotspotSubscriptionAction(
            $repository,
        );

        $result = $action->execute(
            $subscription
        );

        $this->assertTrue($result);
    }
}
