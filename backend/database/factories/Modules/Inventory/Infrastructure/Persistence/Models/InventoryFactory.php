<?php

declare(strict_types=1);

namespace Database\Factories\Modules\Inventory\Infrastructure\Persistence\Models;

use App\Models\Tenant;
use App\Modules\Inventory\Infrastructure\Persistence\Models\Inventory;
use Illuminate\Database\Eloquent\Factories\Factory;

class InventoryFactory extends Factory
{
    protected $model = Inventory::class;

    public function definition(): array
    {
        return [
            'tenant_id' => Tenant::factory(),
            'device_type' => fake()->randomElement([
                'onu',
                'router',
                'mikrotik',
                'switch',
                'olt',
            ]),
            'brand' => fake()->company(),
            'model' => fake()->bothify('MODEL-###'),
            'quantity' => fake()->numberBetween(0, 100),
            'minimum_quantity' => fake()->numberBetween(0, 20),
            'notes' => null,
        ];
    }
}
