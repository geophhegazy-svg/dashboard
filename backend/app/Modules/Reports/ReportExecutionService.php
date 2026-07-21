<?php

declare(strict_types=1);

namespace App\Modules\Reports;

use App\Contracts\Repositories\ReportExportRepositoryInterface;
use App\Contracts\Repositories\ReportRepositoryInterface;
use App\Reports\Export\ExportManager;
use App\Reports\Manager\ReportManager;
use App\Reports\DTO\ExportResult;
use App\Reports\DTO\ReportResult;
use App\Reports\Filters\ReportFilter;
use Carbon\Carbon;


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
        $filter = new ReportFilter(
            from: isset($filters['from'])
                ? Carbon::parse($filters['from'])
                : null,

            to: isset($filters['to'])
                ? Carbon::parse($filters['from'])
                : null,

            tenantId: $filters['tenant_id'] ?? null,
            customerId: $filters['customer_id'] ?? null,
            packageId: $filters['package_id'] ?? null,

            subscriptionStatus: $filters['subscription_status'] ?? null,
            invoiceStatus: $filters['invoice_status'] ?? null,
            paymentMethod: $filters['payment_method'] ?? null,

            search: $filters['search'] ?? null,

            sortBy: $filters['sort_by'] ?? null,
            sortDirection: $filters['sort_direction'] ?? 'asc',

            page: $filters['page'] ?? 1,
            perPage: $filters['per_page'] ?? 50,
        );

        $report = $this->reportManager->run(
            $reportName,
            $filter
        );

        // Export result
        $export = $this->exportManager->export(
            $report,
            $format
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
            'file_name'     => $export->filename,
            'mime_type'     => $export->mimeType,
            'records_count' => count($report->rows),
            'filters'       => $filters,
            'exported_at'   => now(),
        ]);
    }
}
