<?php

declare(strict_types=1);

namespace Database\Factories\Modules\Package\Infrastructure\Persistence\Models;

use App\Modules\Package\Infrastructure\Persistence\Models\Package;
use App\Models\Tenant;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Package>
 */
class PackageFactory extends Factory
{
    protected $model = Package::class;

    public function definition(): array
    {
        return [
            'tenant_id' => Tenant::factory(),

            'name' => 'Home 30M',

            'download_speed' => 30,

            'upload_speed' => 10,

            'price' => 350,

            'quota_gb' => 500,

            'status' => 'active',

            'description' => fake()->sentence(),

            'mikrotik_profile' => 'default',

            'billing_cycle' => 'month',

            'billing_interval' => 1,

            'grace_days' => 0,

            'auto_suspend' => true,

            'auto_expire' => true,
        ];
    }
}
