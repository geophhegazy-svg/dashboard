<?php

declare(strict_types=1);

namespace Database\Factories\Modules\Subscription\Infrastructure\Persistence\Models;

use App\Modules\Customer\Infrastructure\Persistence\Models\Customer;
use App\Modules\Package\Infrastructure\Persistence\Models\Package;
use App\Modules\Subscription\Infrastructure\Persistence\Models\HotspotSubscription;
use App\Models\Tenant;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<HotspotSubscription>
 */
class HotspotSubscriptionFactory extends Factory
{
    protected $model = HotspotSubscription::class;

    public function definition(): array
    {
        return [
            'tenant_id' => Tenant::factory(),
            'customer_id' => Customer::factory(),
            'package_id' => Package::factory(),
            'hotspot_username' => 'hs_' . fake()->unique()->userName(),
            'hotspot_password' => fake()->password(8, 16),
            'mikrotik_profile' => 'default',
            'start_date' => now()->toDateString(),
            'end_date' => now()->addMonth()->toDateString(),
            'monthly_price' => fake()->randomFloat(2, 50, 1000),
            'status' => 'active',
        ];
    }
}
