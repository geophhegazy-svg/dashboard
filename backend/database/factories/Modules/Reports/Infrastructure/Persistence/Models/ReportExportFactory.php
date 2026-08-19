<?php

declare(strict_types=1);

namespace Database\Factories\Modules\Reports\Infrastructure\Persistence\Models;

use App\Models\User;
use App\Modules\Reports\Infrastructure\Persistence\Models\Report;
use App\Modules\Reports\Infrastructure\Persistence\Models\ReportExport;
use Illuminate\Database\Eloquent\Factories\Factory;

final class ReportExportFactory extends Factory
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
