<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\ScheduledReport;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ScheduledReportFactory extends Factory
{
    protected $model = ScheduledReport::class;

    public function definition(): array
    {
        return [
            'name' => fake()->sentence(3),

            'report_name' => fake()->randomElement([
                'customers',
                'subscriptions',
                'payments',
                'wallets',
                'invoices',
            ]),

            'frequency' => fake()->randomElement([
                'daily',
                'weekly',
                'monthly',
            ]),

            'format' => fake()->randomElement([
                'csv',
                'xlsx',
            ]),

            'filters' => [],

            'email' => fake()->safeEmail(),

            'is_active' => true,

            'last_run_at' => null,

            'next_run_at' => now()->addDay(),

            'created_by' => User::factory(),
        ];
    }
}
