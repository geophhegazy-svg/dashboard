<?php

declare(strict_types=1);

namespace App\Modules\Reports\Application\Actions;

use App\Modules\Reports\Application\DTO\ExportResult;
use App\Modules\Reports\Application\Filters\ReportFilter;
use App\Modules\Reports\Application\Manager\ExportManager;
use App\Modules\Reports\Application\Manager\ReportManager;
use Carbon\Carbon;

final readonly class ExecuteReportAction
{
    public function __construct(
        private ReportManager $reportManager,
        private ExportManager $exportManager,
    ) {}

    /**
     * Execute a report and export it.
     */
    public function execute(
        string $reportName,
        string $format = 'csv',
        array $filters = [],
    ): ExportResult {
        $filter = new ReportFilter(
            from: isset($filters['from'])
                ? Carbon::parse($filters['from'])
                : null,

            to: isset($filters['to'])
                ? Carbon::parse($filters['to'])
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
            $filter,
        );

        $export = $this->exportManager->export(
            $report,
            $format,
        );

        return $export;
    }

}
