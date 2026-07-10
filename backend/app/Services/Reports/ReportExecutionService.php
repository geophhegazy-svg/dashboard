<?php

declare(strict_types=1);

namespace App\Services\Reports;

use App\Contracts\Repositories\ReportExportRepositoryInterface;
use App\Contracts\Repositories\ReportRepositoryInterface;
use App\Reports\Export\ExportManager;
use App\Reports\Manager\ReportManager;
use App\Reports\DTO\ExportResult;
use App\Reports\DTO\ReportResult;

class ReportExecutionService
{
    public function __construct(
        private readonly ReportManager $reportManager,
        private readonly ExportManager $exportManager,
        private readonly ReportRepositoryInterface $reportRepository,
        private readonly ReportExportRepositoryInterface $reportExportRepository,
    ) {}

    /**
     * Execute a report and export it.
     */
    public function execute(
        string $reportName,
        string $format = 'csv',
        array $filters = []
    ): ExportResult {
        // Execute report
        $report = $this->reportManager->run(
            $reportName,
            $filters
        );

        // Export result
        $export = $this->exportManager->export(
            $format,
            $report
        );

        // Persist execution history
        $this->storeExecution(
            reportName: $reportName,
            format: $format,
            report: $report,
            export: $export,
            filters: $filters,
        );

        return $export;
    }

    /**
     * Save export history.
     */
    protected function storeExecution(
        string $reportName,
        string $format,
        ReportResult $report,
        ExportResult $export,
        array $filters = []
    ): void {
        $this->reportExportRepository->create([
            'report_name'   => $reportName,
            'format'        => $format,
            'file_name'     => $export->fileName,
            'mime_type'     => $export->mimeType,
            'records_count' => count($report->rows),
            'filters'       => $filters,
            'exported_at'   => now(),
        ]);
    }
}
