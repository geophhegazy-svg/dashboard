<?php

declare(strict_types=1);

namespace App\Modules\Invoice\Infrastructure\Repositories;

use App\Modules\Invoice\Domain\Contracts\InvoiceRepositoryInterface;
use App\Modules\Invoice\Infrastructure\Persistence\Models\Invoice;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;


class InvoiceRepository implements InvoiceRepositoryInterface
{
    public function all(): Collection
    {
        return Invoice::all();
    }

    public function find(int $id): ?Invoice
    {
        return Invoice::find($id);
    }

    public function findForPayment(
        int $invoiceId,
    ): Invoice {
        return Invoice::query()
            ->with('subscription')
            ->lockForUpdate()
            ->findOrFail($invoiceId);
    }

    public function findBySubscriptionId(
        int $subscriptionId,
    ): ?Invoice {
        return Invoice::where(
            'subscription_id',
            $subscriptionId,
        )->first();
    }

    public function findByRenewalKey(
        string $renewalKey,
    ): ?Invoice {
        return Invoice::where(
            'renewal_key',
            $renewalKey,
        )->first();
    }

    public function findByCustomerId(
        int $customerId,
        int $limit = 3,
    ): Collection {
        return Invoice::query()
            ->where('customer_id', $customerId)
            ->latest()
            ->take($limit)
            ->get([
                'invoice_number',
                'amount',
                'status',
                'paid_at',
            ]);
    }

    public function findByCustomerIdAndId(
        int $customerId,
        int $invoiceId,
    ): ?Invoice {
        return Invoice::query()
            ->where('customer_id', $customerId)
            ->whereKey($invoiceId)
            ->first();
    }

    public function countByCustomerId(
        int $customerId,
    ): int {
        return Invoice::query()
            ->where('customer_id', $customerId)
            ->count();
    }

    public function countByCustomerAndStatus(
        int $customerId,
        string $status,
    ): int {
        return Invoice::query()
            ->where('customer_id', $customerId)
            ->where('status', $status)
            ->count();
    }

    public function countAll(): int
    {
        return Invoice::query()->count();
    }

    public function countByStatus(
        string $status,
    ): int {
        return Invoice::query()
            ->where('status', $status)
            ->count();
    }

    public function sumPaidForCurrentMonth(): float
    {
        return (float) Invoice::query()
            ->where('status', 'paid')
            ->whereYear('paid_at', now()->year)
            ->whereMonth('paid_at', now()->month)
            ->sum('amount');
    }

    public function queryForReport(): Builder
    {
        return Invoice::query()->with([
            'customer',
            'subscription',
        ]);
    }

    public function create(
        array $attributes,
    ): Invoice {
        return Invoice::create(
            $attributes
        );
    }

    public function save(
        Invoice $invoice,
    ): bool {
        return $invoice->save();
    }

    public function update(
        Invoice $invoice,
        array $attributes,
    ): bool {
        return $invoice->update(
            $attributes
        );
    }

    public function fresh(
        Invoice $invoice,
        array $relations = [],
    ): Invoice {
        return $invoice->fresh(
            $relations
        );
    }

    public function delete(
        Invoice $invoice,
    ): bool {
        return (bool) $invoice->delete();
    }

    public function paginateByCustomerId(
        int $customerId,
        int $perPage = 10,
    ): LengthAwarePaginator {
        return Invoice::query()
            ->where('customer_id', $customerId)
            ->latest()
            ->paginate($perPage);
    }

    public function paginate(
        int $perPage = 15,
    ): LengthAwarePaginator {

        return Invoice::query()
            ->with([
                'customer',
                'subscription',
            ])
            ->latest()
            ->paginate($perPage);
    }
}
