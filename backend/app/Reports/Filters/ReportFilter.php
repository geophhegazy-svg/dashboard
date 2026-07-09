<?php

declare(strict_types=1);

namespace App\Reports\Filters;

use Carbon\Carbon;

class ReportFilter
{
    public function __construct(
        public readonly ?Carbon $from = null,
        public readonly ?Carbon $to = null,
        public readonly ?int $tenantId = null,
        public readonly ?int $customerId = null,
        public readonly ?int $packageId = null,
        public readonly ?string $subscriptionStatus = null,
        public readonly ?string $invoiceStatus = null,
        public readonly ?string $paymentMethod = null,
        public readonly ?string $search = null,
        public readonly ?string $sortBy = null,
        public readonly string $sortDirection = 'asc',
        public readonly int $page = 1,
        public readonly int $perPage = 50,
    ) {}

    /**
     * Check if date filter exists.
     */
    public function hasDateRange(): bool
    {
        return $this->from !== null || $this->to !== null;
    }

    /**
     * Export filter as array.
     */
    public function toArray(): array
    {
        return [
            'from' => $this->from?->toDateString(),
            'to' => $this->to?->toDateString(),
            'tenant_id' => $this->tenantId,
            'customer_id' => $this->customerId,
            'package_id' => $this->packageId,
            'subscription_status' => $this->subscriptionStatus,
            'invoice_status' => $this->invoiceStatus,
            'payment_method' => $this->paymentMethod,
            'search' => $this->search,
            'sort_by' => $this->sortBy,
            'sort_direction' => $this->sortDirection,
            'page' => $this->page,
            'per_page' => $this->perPage,
        ];
    }
}
