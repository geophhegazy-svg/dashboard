<?php

declare(strict_types=1);

namespace Database\Factories\Modules\Network\Infrastructure\Persistence\Models;

use App\Models\Tenant;
use App\Modules\Customer\Infrastructure\Persistence\Models\Area;
use App\Modules\Customer\Infrastructure\Persistence\Models\Customer;
use App\Modules\Network\Infrastructure\Persistence\Models\NetworkService;
use App\Modules\Package\Infrastructure\Persistence\Models\Package;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<NetworkService>
 */
class NetworkServiceFactory extends Factory
{
    protected $model = NetworkService::class;

    public function definition(): array
    {
        $startsAt = now();

        return [
            'tenant_id' => Tenant::factory(),
            'customer_id' => Customer::factory(),
            'area_id' => Area::factory(),
            'package_id' => Package::factory(),
            'network_device_id' => null,
            'connection_type' => 'pppoe',
            'username' => fake()->unique()->userName(),
            'password' => '123456',
            'mac_address' => fake()->macAddress(),
            'ip_address' => null,
            'ip_mode' => 'dynamic',
            'starts_at' => $startsAt,
            'ends_at' => $startsAt->copy()->addMonth(),
            'status' => 'pending',
            'provisioning_status' => 'pending',
            'last_provisioned_at' => null,
            'last_sync_at' => null,
            'last_error' => null,
        ];
    }

    public function configure(): static
    {
        return $this->afterCreating(function (NetworkService $service): void {
            $tenantId = $service->tenant_id;

            $service->customer()->update([
                'tenant_id' => $tenantId,
            ]);

            if ($service->area_id !== null) {
                $service->area()->update([
                    'tenant_id' => $tenantId,
                ]);
            }

            $service->package()->update([
                'tenant_id' => $tenantId,
            ]);
        });
    }

    public function hotspot(): static
    {
        return $this->state(fn () => [
            'connection_type' => 'hotspot',
        ]);
    }

    public function staticIp(): static
    {
        return $this->state(fn () => [
            'ip_mode' => 'static',
            'ip_address' => fake()->ipv4(),
        ]);
    }

    public function provisioned(): static
    {
        return $this->state(fn () => [
            'provisioning_status' => 'provisioned',
            'last_provisioned_at' => now(),
        ]);
    }
}
