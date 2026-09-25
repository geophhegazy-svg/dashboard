<?php

declare(strict_types=1);

namespace Tests\Feature\Security;

use App\Modules\Customer\Infrastructure\Persistence\Models\Customer;
use App\Modules\Subscription\Infrastructure\Persistence\Models\Subscription;
use App\Modules\Network\Application\Contracts\NetworkDeviceResolverInterface;
use App\Modules\Network\Application\Contracts\NetworkManagerInterface;
use App\Modules\Network\Domain\Contracts\MikrotikServiceInterface;
use App\Modules\Network\Infrastructure\Persistence\Models\NetworkDevice;
use App\Modules\Package\Infrastructure\Persistence\Models\Package;
use Mockery;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

final class CustomerApiOwnershipContractTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $deviceResolver = Mockery::mock(
            NetworkDeviceResolverInterface::class
        );

        $device = new NetworkDevice([
            'name' => 'Test MikroTik',
            'ip_address' => '127.0.0.1',
            'username' => 'test',
            'password' => 'test',
            'type' => 'mikrotik',
            'port' => 8728,
            'status' => 'active',
        ]);

        $device->id = 1;

        $deviceResolver
            ->shouldReceive('resolveForSubscription')
            ->zeroOrMoreTimes()
            ->with(Mockery::type(Subscription::class))
            ->andReturn($device);

        $this->app->instance(
            NetworkDeviceResolverInterface::class,
            $deviceResolver
        );

        $networkManager = Mockery::mock(
            NetworkManagerInterface::class
        );

        $networkManager
            ->shouldReceive('connect')
            ->zeroOrMoreTimes()
            ->with(1)
            ->andReturnTrue();

        $this->app->instance(
            NetworkManagerInterface::class,
            $networkManager
        );
    }

    public function test_customer_can_logout_current_sanctum_token(): void
    {
        $customer = Customer::factory()->create();

        Sanctum::actingAs($customer);

        $response = $this->postJson('/api/customer/logout');

        $response
            ->assertOk()
            ->assertJson([
                'message' => 'Logged out successfully',
            ]);
    }

    public function test_customer_can_update_own_profile(): void
    {
        $customer = Customer::factory()->create([
            'name' => 'Old Name',
        ]);

        Sanctum::actingAs($customer);

        $response = $this->putJson('/api/customer/profile', [
            'name' => 'New Name',
        ]);

        $response
            ->assertOk()
            ->assertJsonPath('customer.id', $customer->id)
            ->assertJsonPath('customer.name', 'New Name');

        $this->assertDatabaseHas('customers', [
            'id' => $customer->id,
            'name' => 'New Name',
        ]);
    }

    public function test_customer_can_change_own_password(): void
    {
        $customer = Customer::factory()->create([
            'password' => 'old-password',
        ]);

        Sanctum::actingAs($customer);

        $response = $this->postJson(
            '/api/customer/change-password',
            [
                'current_password' => 'old-password',
                'password' => 'new-password',
                'password_confirmation' => 'new-password',
            ]
        );

        $response
            ->assertOk()
            ->assertJson([
                'message' => 'Password changed successfully',
            ]);
    }

    public function test_customer_cannot_change_password_with_wrong_current_password(): void
    {
        $customer = Customer::factory()->create([
            'password' => 'old-password',
        ]);

        Sanctum::actingAs($customer);

        $response = $this->postJson(
            '/api/customer/change-password',
            [
                'current_password' => 'wrong-password',
                'password' => 'new-password',
                'password_confirmation' => 'new-password',
            ]
        );

        $response
            ->assertStatus(422)
            ->assertJson([
                'message' => 'Current password is incorrect',
            ]);
    }

    public function test_customer_subscription_renew_uses_authenticated_customer_ownership(): void
    {
        $customer = Customer::factory()->create();

        $otherCustomer = Customer::factory()->create();

        $ownedSubscription = Subscription::factory()->create([
            'customer_id' => $customer->id,
            'tenant_id' => $customer->tenant_id,
            'package_id' => Package::factory()->create(['tenant_id' => $customer->tenant_id])->id,
            'status' => 'expired',
            'end_date' => now()->subDays(5),
        ]);

        Subscription::factory()->create([
            'customer_id' => $otherCustomer->id,
            'tenant_id' => $otherCustomer->tenant_id,
            'package_id' => Package::factory()->create(['tenant_id' => $otherCustomer->tenant_id])->id,
            'status' => 'expired',
            'end_date' => now()->subDays(5),
        ]);

        $mikrotik = Mockery::mock(MikrotikServiceInterface::class);
        $mikrotik->shouldReceive('enableUser')
            ->once()
            ->with($ownedSubscription->pppoe_username)
            ->andReturn(true);

        $this->app->instance(
            MikrotikServiceInterface::class,
            $mikrotik
        );

        Sanctum::actingAs($customer);

        $response = $this->postJson(
            '/api/customer/subscription/renew',
            [
                'days' => 30,
            ]
        );

        $response->assertOk();

        $ownedSubscription->refresh();

        $this->assertTrue(
            $ownedSubscription->isActive()
        );

        $this->assertGreaterThan(
            now(),
            $ownedSubscription->end_date
        );
    }

    public function test_customer_subscription_renew_does_not_accept_foreign_subscription_id(): void
    {
        $customer = Customer::factory()->create();

        $otherCustomer = Customer::factory()->create();

        $ownedSubscription = Subscription::factory()->create([
            'customer_id' => $customer->id,
            'tenant_id' => $customer->tenant_id,
            'package_id' => Package::factory()->create(['tenant_id' => $customer->tenant_id])->id,
            'status' => 'expired',
            'end_date' => now()->subDays(5),
        ]);

        $foreignSubscription = Subscription::factory()->create([
            'customer_id' => $otherCustomer->id,
            'tenant_id' => $otherCustomer->tenant_id,
            'package_id' => Package::factory()->create(['tenant_id' => $otherCustomer->tenant_id])->id,
            'status' => 'expired',
            'end_date' => now()->subDays(5),
        ]);

        $mikrotik = Mockery::mock(MikrotikServiceInterface::class);
        $mikrotik->shouldReceive('enableUser')
            ->once()
            ->with($ownedSubscription->pppoe_username)
            ->andReturn(true);

        $this->app->instance(
            MikrotikServiceInterface::class,
            $mikrotik
        );

        Sanctum::actingAs($customer);

        $response = $this->postJson(
            '/api/customer/subscription/renew',
            [
                'subscription_id' => $foreignSubscription->id,
                'days' => 30,
            ]
        );

        $response->assertOk();

        $ownedSubscription->refresh();
        $foreignSubscription->refresh();

        $this->assertTrue(
            $ownedSubscription->isActive()
        );

        $this->assertFalse(
            $foreignSubscription->isActive()
        );
    }
}
