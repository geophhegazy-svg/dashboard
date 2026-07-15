<?php

namespace Database\Factories\Modules\Subscription\Infrastructure\Persistence\Models;

use App\Modules\Subscription\Infrastructure\Persistence\Models\Subscription;
use App\Models\Customer;
use App\Models\Package;
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

            'start_date' => now(),
            'end_date' => now()->addMonth(),

            'monthly_price' => 350,
            'wallet_balance' => 0,

            'status' => 'active',

            'notes' => fake()->sentence(),

            'pppoe_username' => fake()->userName(),
            'pppoe_password' => '123456',

            'mikrotik_profile' => 'default',
        ];
    }

    public function suspended(): static
    {
        return $this->state(fn() => [
            'status' => 'suspended',
        ]);
    }

    public function expired(): static
    {
        return $this->state(fn() => [
            'status' => 'expired',
        ]);
    }

    public function active(): static
    {
        return $this->state(fn() => [
            'status' => 'active',
        ]);
    }
}
