<?php

declare(strict_types=1);

namespace Database\Factories\Modules\Customer\Infrastructure\Persistence\Models;

use App\Models\Tenant;
use App\Modules\Customer\Infrastructure\Persistence\Models\Area;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Area>
 */
class AreaFactory extends Factory
{
    protected $model = Area::class;

    public function definition(): array
    {
        return [
            'tenant_id' => Tenant::factory(),
            'name' => fake()->unique()->city(),
            'code' => strtoupper(fake()->unique()->lexify('AREA??')),
            'status' => 'active',
            'notes' => fake()->optional()->sentence(),
        ];
    }

    public function inactive(): static
    {
        return $this->state(fn () => [
            'status' => 'inactive',
        ]);
    }
}
