<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Report;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ReportFactory extends Factory
{
    protected $model = Report::class;

    public function definition(): array
    {
        return [
            'name' => 'customers',
            'title' => 'Customers Report',
            'type' => 'manual',
            'filters' => [],
            'status' => 'completed',
            'generated_by' => User::factory(),
            'generated_at' => now(),
        ];
    }
}
