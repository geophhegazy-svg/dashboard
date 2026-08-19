<?php

declare(strict_types=1);

namespace Database\Factories\Modules\Reports\Infrastructure\Persistence\Models;

use App\Models\User;
use App\Modules\Reports\Infrastructure\Persistence\Models\Report;
use Illuminate\Database\Eloquent\Factories\Factory;

final class ReportFactory extends Factory
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
