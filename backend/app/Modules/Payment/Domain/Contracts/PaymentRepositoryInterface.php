<?php

declare(strict_types=1);

namespace App\Modules\Payment\Domain\Contracts;

use App\Modules\Payment\Infrastructure\Persistence\Models\Payment;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface PaymentRepositoryInterface
{
    public function all(): Collection;

    public function latest(): Collection;

    public function find(int $id): ?Payment;

    public function create(
        array $data,
    ): Payment;

    public function save(Payment $payment): bool;

    public function delete(Payment $payment): bool;

    public function countAll(): int;

    public function sumAll(): float;

    public function sumByInvoiceId(
        int $invoiceId,
    ): float;

    public function sumForCurrentMonth(): float;

    public function paginate(
        int $perPage = 15,
    ): LengthAwarePaginator;
}
