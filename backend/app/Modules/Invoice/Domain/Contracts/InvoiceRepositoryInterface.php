<?php

declare(strict_types=1);

namespace App\Modules\Invoice\Domain\Contracts;

use App\Modules\Invoice\Infrastructure\Persistence\Models\Invoice;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface InvoiceRepositoryInterface
{
    public function all(): Collection;

    public function find(int $id): ?Invoice;

    public function findForPayment(
        int $invoiceId,
    ): Invoice;

    public function findBySubscriptionId(
        int $subscriptionId,
    ): ?Invoice;

    public function findByRenewalKey(
        string $renewalKey,
    ): ?Invoice;

    public function findByCustomerId(
        int $customerId,
        int $limit = 3,
    ): Collection;

    public function findByCustomerIdAndId(
        int $customerId,
        int $invoiceId,
    ): ?Invoice;

    public function countByCustomerId(
        int $customerId,
    ): int;

    public function countByCustomerAndStatus(
        int $customerId,
        string $status,
    ): int;

    public function countAll(): int;

    public function countByStatus(
        string $status,
    ): int;

    public function sumPaidForCurrentMonth(): float;

    public function queryForReport(): \Illuminate\Database\Eloquent\Builder;

    public function create(
        array $attributes,
    ): Invoice;

    public function save(Invoice $invoice): bool;

    public function update(
        Invoice $invoice,
        array $attributes,
    ): bool;

    public function fresh(
        Invoice $invoice,
        array $relations = [],
    ): Invoice;

    public function delete(Invoice $invoice): bool;

    public function paginate(
        int $perPage = 15,
    ): LengthAwarePaginator;

    public function paginateByCustomerId(
        int $customerId,
        int $perPage = 10,
    ): LengthAwarePaginator;
}
