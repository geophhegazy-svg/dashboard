<?php

namespace Database\Factories;

use App\Models\Package;
use App\Models\Tenant;
use Illuminate\Database\Eloquent\Factories\Factory;

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
        ];
    }
}
