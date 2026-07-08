<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Enums\AccountNature;
use App\Enums\AccountType;
use App\Models\Account;
use App\Models\Tenant;
use Illuminate\Database\Eloquent\Factories\Factory;

class AccountFactory extends Factory
{
    protected $model = Account::class;

    public function definition(): array
    {
        return [

            'tenant_id' => Tenant::factory(),

            'parent_id' => null,

            'code' => $this->faker->unique()->numerify('####'),

            'name' => $this->faker->company(),

            'type' => AccountType::ASSET->value,

            'nature' => AccountNature::DEBIT->value,

            'level' => 1,

            'is_system' => false,

            'is_active' => true,

            'description' => $this->faker->sentence(),

        ];
    }
}
