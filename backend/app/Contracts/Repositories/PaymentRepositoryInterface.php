<?php

declare(strict_types=1);

namespace App\Contracts\Repositories;

use App\Models\Payment;
use Illuminate\Database\Eloquent\Collection;

interface PaymentRepositoryInterface
{
    public function all(): Collection;

    public function find(int $id): ?Payment;

    public function save(Payment $payment): bool;

    public function delete(Payment $payment): bool;
}