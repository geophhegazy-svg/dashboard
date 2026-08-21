<?php

declare(strict_types=1);

namespace Database\Factories\Modules\Inventory\Infrastructure\Persistence\Models;

use App\Models\Tenant;
use App\Modules\Inventory\Infrastructure\Persistence\Models\Device;
use Illuminate\Database\Eloquent\Factories\Factory;

class DeviceFactory extends Factory
{
    protected $model = Device::class;

    public function definition(): array
    {
        return [
            'tenant_id' => Tenant::factory(),
            'customer_id' => null,
            'device_type' => fake()->randomElement([
                'onu',
                'router',
                'mikrotik',
                'switch',
                'olt',
            ]),
            'brand' => fake()->company(),
            'model' => fake()->bothify('MODEL-###'),
            'serial_number' => fake()->unique()->bothify('SN-########'),
            'mac_address' => fake()->macAddress(),
            'ip_address' => fake()->ipv4(),
            'status' => 'active',
            'notes' => null,
        ];
    }
}
