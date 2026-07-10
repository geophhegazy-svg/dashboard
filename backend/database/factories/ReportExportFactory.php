<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Report;
use App\Models\ReportExport;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ReportExportFactory extends Factory
{
    protected $model = ReportExport::class;

    public function definition(): array
    {
        return [
            'report_id' => Report::factory(),
            'format' => 'csv',
            'filename' => 'customers.csv',
            'disk' => 'local',
            'path' => 'reports/customers.csv',
            'mime_type' => 'text/csv',
            'size' => 1024,
            'exported_by' => User::factory(),
            'exported_at' => now(),
        ];
    }
}
