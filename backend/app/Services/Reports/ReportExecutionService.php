<?php

declare(strict_types=1);

namespace App\Services\Reports;

use Illuminate\Support\Facades\DB;
use App\Reports\DTO\ExportResult;
use App\Reports\Manager\ReportManager;
use App\Reports\Export\ExportManager;
use App\Repositories\Contracts\ReportRepositoryInterface;
use App\Repositories\Contracts\ReportExportRepositoryInterface;

class ReportExecutionService
{
    public function __construct(
        private readonly ReportManager $reportManager,
        private readonly ExportManager $exportManager,
        private readonly ReportRepositoryInterface $reportRepository,
        private readonly ReportExportRepositoryInterface $reportExportRepository,
    ) {}

    public function run(
        string $reportName,
        array $filters = [],
        string $format = 'csv'
    ): ExportResult {

        return DB::transaction(function () use (
            $reportName,
            $filters,
            $format
        ) {

            $report = $this->reportManager->run(
                $reportName,
                $filters
            );

            $export = $this->exportManager->export(
                $report,
                $format
            );

            $savedReport = $this->reportRepository->create([
                'name' => $report->name,
                'title' => $report->title,
                'description' => null,
                'type' => $format,
                'enabled' => true,
            ]);

            $this->reportExportRepository->create([
                'report_id' => $savedReport->id,
                'filename' => $export->filename,
                'mime_type' => $export->mimeType,
                'size' => $export->size,
                'status' => 'completed',
            ]);

            return $export;
        });
    }
}
