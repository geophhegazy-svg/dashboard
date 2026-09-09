<?php

declare(strict_types=1);

namespace App\Modules\Payment\Infrastructure\Repositories;

use App\Modules\Payment\Domain\Contracts\PaymentRepositoryInterface;
use App\Modules\Payment\Infrastructure\Persistence\Models\Payment;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class PaymentRepository implements PaymentRepositoryInterface
{
    public function all(): Collection
    {
        return Payment::all();
    }

    public function latest(): Collection
    {
        return Payment::latest()->get();
    }

    public function find(int $id): ?Payment
    {
        return Payment::find($id);
    }

    public function create(
        array $data,
    ): Payment {

        return Payment::create($data);
    }

    public function save(Payment $payment): bool
    {
        return $payment->save();
    }

    public function countAll(): int
    {
        return Payment::count();
    }

    public function sumAll(): float
    {
        return (float) Payment::sum('amount');
    }

    public function sumByInvoiceId(
        int $invoiceId,
    ): float {
        return (float) Payment::query()
            ->where('invoice_id', $invoiceId)
            ->sum('amount');
    }

    public function sumForCurrentMonth(): float
    {
        return (float) Payment::query()
            ->whereYear('payment_date', now()->year)
            ->whereMonth('payment_date', now()->month)
            ->sum('amount');
    }

    public function paginate(
        int $perPage = 15,
    ): LengthAwarePaginator {
        return Payment::latest()->paginate($perPage);
    }
}
