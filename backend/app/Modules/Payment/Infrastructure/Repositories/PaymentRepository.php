<?php

declare(strict_types=1);

namespace App\Modules\Payment\Infrastructure\Repositories;

use App\Modules\Payment\Domain\Contracts\PaymentRepositoryInterface;
use App\Modules\Payment\Infrastructure\Persistence\Models\Payment;
use Illuminate\Database\Eloquent\Collection;

class PaymentRepository implements PaymentRepositoryInterface
{
    public function all(): Collection
    {
        return Payment::all();
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

    public function delete(Payment $payment): bool
    {
        return (bool) $payment->delete();
    }
}
