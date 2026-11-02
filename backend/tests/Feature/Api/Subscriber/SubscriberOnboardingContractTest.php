<?php

declare(strict_types=1);

namespace Tests\Feature\Api\Subscriber;

use App\Modules\Customer\Infrastructure\Persistence\Models\Customer;
use App\Modules\Network\Infrastructure\Persistence\Models\NetworkDevice;
use App\Modules\Network\Infrastructure\Persistence\Models\NetworkService;
use App\Modules\Package\Infrastructure\Persistence\Models\Package;
use App\Modules\Subscription\Infrastructure\Persistence\Models\Subscription;
use App\Models\User;
use App\Models\Tenant;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Permission;
use Tests\TestCase;

final class SubscriberOnboardingContractTest extends TestCase
{
    use RefreshDatabase;

    public function test_onboarding_creates_customer_subscription_and_network_service_and_links_them(): void
    {
        $tenant = Tenant::factory()->create();

        $user = User::factory()->create([
            'tenant_id' => $tenant->id,
        ]);

        foreach ([
            'customers.create',
            'subscriptions.create',
            'network_services.create',
        ] as $permission) {
            Permission::findOrCreate($permission, 'web');
            $user->givePermissionTo($permission);
        }

        $package = Package::factory()->create([
            'tenant_id' => $tenant->id,
            'price' => 100,
            'mikrotik_profile' => 'default',
        ]);

        $device = NetworkDevice::query()->create([
            'tenant_id' => $tenant->id,
            'name' => 'Wizard MikroTik',
            'ip_address' => '192.0.2.1',
            'username' => 'admin',
            'password' => 'secret',
            'type' => 'mikrotik',
            'port' => 8728,
            'status' => 'active',
            'is_online' => true,
        ]);

        $payload = [
            'tenant_id' => $tenant->id,

            'customer' => [
                'name' => 'Wizard Customer',
                'phone' => '01000000000',
                'email' => null,
                'address' => null,
                'national_id' => null,
                'status' => 'active',
                'notes' => null,
            ],

            'subscription' => [
                'package_id' => $package->id,
                'start_date' => '2026-10-01',
                'end_date' => null,
                'monthly_price' => 100,
                'status' => 'pending',
                'notes' => null,
            ],

            'network_service' => [
                'area_id' => null,
                'network_device_id' => $device->id,
                'connection_type' => 'pppoe',
                'username' => 'wizard-user',
                'password' => 'secret-password',
                'mac_address' => null,
                'ip_address' => null,
                'ip_mode' => 'dynamic',
                'starts_at' => '2026-10-01',
                'ends_at' => null,
                'status' => 'pending',
            ],
        ];

        $response = $this
            ->actingAs($user)
            ->postJson('/api/subscriber-onboarding', $payload);

        $response
            ->assertCreated()
            ->assertJsonPath('data.customer.name', 'Wizard Customer')
            ->assertJsonPath('data.subscription.package_id', $package->id)
            ->assertJsonPath('data.network_service.network_device_id', $device->id);

        $customer = Customer::query()
            ->where('tenant_id', $tenant->id)
            ->where('phone', '01000000000')
            ->firstOrFail();

        $subscription = Subscription::query()
            ->where('tenant_id', $tenant->id)
            ->where('customer_id', $customer->id)
            ->firstOrFail();

        $networkService = NetworkService::query()
            ->where('tenant_id', $tenant->id)
            ->where('customer_id', $customer->id)
            ->firstOrFail();

        $this->assertSame(
            $networkService->id,
            $subscription->network_service_id
        );
    }

    public function test_onboarding_requires_all_three_create_permissions(): void
    {
        $tenant = Tenant::factory()->create();

        $user = User::factory()->create([
            'tenant_id' => $tenant->id,
        ]);

        $package = Package::factory()->create([
            'tenant_id' => $tenant->id,
            'price' => 100,
        ]);

        $device = NetworkDevice::query()->create([
            'tenant_id' => $tenant->id,
            'name' => 'Permission Test MikroTik',
            'ip_address' => '192.0.2.2',
            'username' => 'admin',
            'password' => 'secret',
            'type' => 'mikrotik',
            'port' => 8728,
            'status' => 'active',
            'is_online' => true,
        ]);

        $payload = [
            'tenant_id' => $tenant->id,

            'customer' => [
                'name' => 'Permission Test Customer',
                'phone' => '01000000001',
                'email' => null,
                'address' => null,
                'national_id' => null,
                'status' => 'active',
                'notes' => null,
            ],

            'subscription' => [
                'package_id' => $package->id,
                'start_date' => '2026-10-01',
                'end_date' => null,
                'monthly_price' => 100,
                'status' => 'pending',
                'notes' => null,
            ],

            'network_service' => [
                'area_id' => null,
                'network_device_id' => $device->id,
                'connection_type' => 'pppoe',
                'username' => 'permission-test-user',
                'password' => 'secret-password',
                'mac_address' => null,
                'ip_address' => null,
                'ip_mode' => 'dynamic',
                'starts_at' => '2026-10-01',
                'ends_at' => null,
                'status' => 'pending',
            ],
        ];

        $this->actingAs($user)
            ->postJson('/api/subscriber-onboarding', $payload)
            ->assertForbidden();
    }

    public function test_onboarding_rolls_back_customer_when_subscription_creation_fails(): void
    {
        $tenant = Tenant::factory()->create();

        $user = User::factory()->create([
            'tenant_id' => $tenant->id,
        ]);

        foreach ([
            'customers.create',
            'subscriptions.create',
            'network_services.create',
        ] as $permission) {
            Permission::findOrCreate($permission, 'web');
            $user->givePermissionTo($permission);
        }

        $payload = [
            'tenant_id' => $tenant->id,

            'customer' => [
                'name' => 'Rollback Customer',
                'phone' => '01000000002',
                'email' => null,
                'address' => null,
                'national_id' => null,
                'status' => 'active',
                'notes' => null,
            ],

            'subscription' => [
                'package_id' => 999999999,
                'start_date' => '2026-10-01',
                'end_date' => null,
                'monthly_price' => 100,
                'status' => 'pending',
                'notes' => null,
            ],

            'network_service' => [
                'area_id' => null,
                'network_device_id' => 999999999,
                'connection_type' => 'pppoe',
                'username' => 'rollback-user',
                'password' => 'secret-password',
                'mac_address' => null,
                'ip_address' => null,
                'ip_mode' => 'dynamic',
                'starts_at' => '2026-10-01',
                'ends_at' => null,
                'status' => 'pending',
            ],
        ];

        $workflow = app(
            \App\Modules\Network\Application\Workflows\OnboardSubscriberWorkflow::class
        );

        $this->expectException(\Throwable::class);

        app(\App\Core\Workflow\WorkflowEngine::class)->run(
            $workflow,
            $payload,
        );

        $this->assertDatabaseMissing('customers', [
            'tenant_id' => $tenant->id,
            'phone' => '01000000002',
        ]);
    }

}
