<?php

declare(strict_types=1);

namespace Tests\Unit\Modules\Subscription;

use App\Modules\Customer\Infrastructure\Persistence\Models\Customer;
use App\Modules\Network\Domain\Contracts\Services\HotspotServiceInterface;
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

    public function test_create_action_creates_routeros_user_before_persisting_subscription(): void
    {
        $customer = Customer::factory()->create();

        $repository = Mockery::mock(
            HotspotSubscriptionRepositoryInterface::class
        );

        $hotspot = Mockery::mock(
            HotspotServiceInterface::class
        );

        $hotspot
            ->shouldReceive('createUser')
            ->once()
            ->with(
                'hs' . $customer->id,
                Mockery::type('string'),
                'default'
            )
            ->andReturnTrue();

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

        $action = new CreateHotspotSubscriptionAction(
            $repository,
            $hotspot,
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

    public function test_activate_action_enables_routeros_user_and_persists_status(): void
    {
        $subscription = new HotspotSubscription([
            'hotspot_username' => 'test-user',
            'status' => 'suspended',
        ]);

        $repository = Mockery::mock(
            HotspotSubscriptionRepositoryInterface::class
        );

        $hotspot = Mockery::mock(
            HotspotServiceInterface::class
        );

        $hotspot
            ->shouldReceive('enableUser')
            ->once()
            ->with('test-user')
            ->andReturnTrue();

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
            $hotspot,
        );

        $result = $action->execute($subscription);

        $this->assertSame(
            'active',
            $result->status
        );
    }

    public function test_suspend_action_disables_routeros_user_and_persists_status(): void
    {
        $subscription = new HotspotSubscription([
            'hotspot_username' => 'test-user',
            'status' => 'active',
        ]);

        $repository = Mockery::mock(
            HotspotSubscriptionRepositoryInterface::class
        );

        $hotspot = Mockery::mock(
            HotspotServiceInterface::class
        );

        $hotspot
            ->shouldReceive('disableUser')
            ->once()
            ->with('test-user')
            ->andReturnTrue();

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
            $hotspot,
        );

        $result = $action->execute($subscription);

        $this->assertSame(
            'suspended',
            $result->status
        );
    }

    public function test_delete_action_deletes_routeros_user_and_database_subscription(): void
    {
        $subscription = new HotspotSubscription([
            'hotspot_username' => 'test-user',
        ]);

        $repository = Mockery::mock(
            HotspotSubscriptionRepositoryInterface::class
        );

        $hotspot = Mockery::mock(
            HotspotServiceInterface::class
        );

        $hotspot
            ->shouldReceive('deleteUser')
            ->once()
            ->with('test-user')
            ->andReturnTrue();

        $repository
            ->shouldReceive('delete')
            ->once()
            ->with($subscription)
            ->andReturnTrue();

        $action = new DeleteHotspotSubscriptionAction(
            $repository,
            $hotspot,
        );

        $result = $action->execute($subscription);

        $this->assertTrue($result);
    }

    public function test_activate_does_not_persist_when_routeros_enable_fails(): void
    {
        $subscription = new HotspotSubscription([
            'hotspot_username' => 'test-user',
            'status' => 'suspended',
        ]);

        $repository = Mockery::mock(
            HotspotSubscriptionRepositoryInterface::class
        );

        $repository
            ->shouldNotReceive('update');

        $hotspot = Mockery::mock(
            HotspotServiceInterface::class
        );

        $hotspot
            ->shouldReceive('enableUser')
            ->once()
            ->with('test-user')
            ->andThrow(
                new \RuntimeException('RouterOS unavailable')
            );

        $action = new ActivateHotspotSubscriptionAction(
            $repository,
            $hotspot,
        );

        $this->expectException(
            \RuntimeException::class
        );

        $action->execute($subscription);
    }

    protected function tearDown(): void
    {
        Mockery::close();

        parent::tearDown();
    }
}
