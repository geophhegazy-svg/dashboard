<?php

declare(strict_types=1);

namespace Database\Factories\Modules\Inventory\Infrastructure\Persistence\Models;

use App\Models\Tenant;
use App\Modules\Customer\Infrastructure\Persistence\Models\Customer;
use App\Modules\Inventory\Infrastructure\Persistence\Models\Device;
use App\Modules\Inventory\Infrastructure\Persistence\Models\DeviceAssignment;
use Illuminate\Database\Eloquent\Factories\Factory;

class DeviceAssignmentFactory extends Factory
{
    protected $model = DeviceAssignment::class;

    public function definition(): array
    {
        return [
            'tenant_id' => Tenant::factory(),
            'customer_id' => Customer::factory(),
            'device_id' => Device::factory(),
            'assigned_at' => now(),
            'returned_at' => null,
            'status' => 'assigned',
            'notes' => null,
        ];
    }
}
