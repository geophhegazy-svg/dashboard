<?php

declare(strict_types=1);

namespace App\Modules\Invoice\Application\Queries\Handlers;

use App\Modules\Invoice\Application\Queries\GetCustomerInvoiceSummaryQuery;
use App\Modules\Invoice\Domain\Contracts\InvoiceRepositoryInterface;

final readonly class GetCustomerInvoiceSummaryQueryHandler
{
    public function __construct(
        private InvoiceRepositoryInterface $repository,
    ) {}

    public function handle(
        GetCustomerInvoiceSummaryQuery $query,
    ): array {
        $customerId = $query->customerId;

        $latestInvoices = $this->repository->findByCustomerId(
            $customerId,
            3,
        );

        return [
            'last_invoice' => $latestInvoices->first(),

            'recent_invoices' => $latestInvoices,

            'total_invoices' => $this->repository->countByCustomerId(
                $customerId,
            ),

            'paid_invoices' => $this->repository->countByCustomerAndStatus(
                $customerId,
                'paid',
            ),

            'unpaid_invoices' => $this->repository->countByCustomerAndStatus(
                $customerId,
                'unpaid',
            ),
        ];
    }
}
