<?php

namespace Database\Factories;

use App\Models\Customer;
use App\Models\Package;
use App\Models\Subscription;
use App\Models\Tenant;
use Illuminate\Database\Eloquent\Factories\Factory;

class SubscriptionFactory extends Factory
{
    protected $model = Subscription::class;

    public function definition(): array
    {
        return [
            'tenant_id' => Tenant::factory(),

            'customer_id' => Customer::factory(),

            'package_id' => Package::factory(),

            'status' => 'active',

            'start_date' => now(),

            'end_date' => now()->addMonth(),

            'pppoe_username' => fake()->userName(),

            'pppoe_password' => fake()->password(),

            'mikrotik_profile' => 'default',

            'monthly_price' => fake()->randomFloat(2, 50, 1000),

            'wallet_balance' => 0,
        ];
    }
}
