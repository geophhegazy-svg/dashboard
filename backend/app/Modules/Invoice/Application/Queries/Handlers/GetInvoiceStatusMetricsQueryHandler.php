<?php

declare(strict_types=1);

namespace App\Modules\Invoice\Application\Queries\Handlers;

use App\Modules\Invoice\Application\Queries\GetInvoiceStatusMetricsQuery;
use App\Modules\Invoice\Domain\Contracts\InvoiceRepositoryInterface;

final readonly class GetInvoiceStatusMetricsQueryHandler
{
    public function __construct(
        private InvoiceRepositoryInterface $repository,
    ) {}

    public function handle(
        GetInvoiceStatusMetricsQuery $query,
    ): array {
        return [
            'paid' => $this->repository->countByStatus('paid'),
            'pending' => $this->repository->countByStatus('pending'),
            'overdue' => $this->repository->countByStatus('overdue'),
            'cancelled' => $this->repository->countByStatus('cancelled'),
        ];
    }
}
