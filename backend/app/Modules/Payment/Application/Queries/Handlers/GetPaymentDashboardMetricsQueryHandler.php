<?php

declare(strict_types=1);

namespace App\Modules\Payment\Application\Queries\Handlers;

use App\Modules\Payment\Application\Queries\GetPaymentDashboardMetricsQuery;
use App\Modules\Payment\Domain\Contracts\PaymentRepositoryInterface;

final readonly class GetPaymentDashboardMetricsQueryHandler
{
    public function __construct(
        private PaymentRepositoryInterface $repository,
    ) {}

    public function handle(
        GetPaymentDashboardMetricsQuery $query,
    ): array {
        return [
            'total_payments' => $this->repository->countAll(),
            'total_revenue' => $this->repository->sumAll(),
            'monthly_revenue' => $this->repository->sumForCurrentMonth(),
        ];
    }
}
