<?php

namespace Database\Factories;

use App\Models\Customer;
use App\Models\Tenant;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

class CustomerFactory extends Factory
{
    protected $model = Customer::class;

    public function definition(): array
    {
        return [
            'tenant_id' => Tenant::factory(),

            'name' => fake()->name(),

            'phone' => fake()->phoneNumber(),

            'email' => fake()->unique()->safeEmail(),

            'address' => fake()->address(),

            'password' => Hash::make('password'),

            'status' => 'active',
        ];
    }
}
