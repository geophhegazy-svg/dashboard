<?php

declare(strict_types=1);

namespace App\Modules\Invoice\Application\Queries\Handlers;

use App\Modules\Invoice\Application\Queries\GetInvoiceDashboardMetricsQuery;
use App\Modules\Invoice\Domain\Contracts\InvoiceRepositoryInterface;

final readonly class GetInvoiceDashboardMetricsQueryHandler
{
    public function __construct(
        private InvoiceRepositoryInterface $repository,
    ) {}

    public function handle(
        GetInvoiceDashboardMetricsQuery $query,
    ): array {
        return [
            'total_invoices' => $this->repository->countAll(),

            'pending_invoices' => $this->repository->countByStatus(
                'pending',
            ),

            'paid_invoices' => $this->repository->countByStatus(
                'paid',
            ),

            'monthly_revenue' => $this->repository->sumPaidForCurrentMonth(),
        ];
    }
}
