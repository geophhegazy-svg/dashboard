<?php

declare(strict_types=1);

namespace App\Modules\Wallet\Domain\Contracts;

use App\Modules\Wallet\Infrastructure\Persistence\Models\Wallet;
use App\Modules\Wallet\Infrastructure\Persistence\Models\WalletTransaction;

interface WalletRepositoryInterface
{
    public function findByCustomerId(
        int $tenantId,
        int $customerId,
    ): ?Wallet;

    public function create(
        array $data,
    ): Wallet;

    public function paginateTransactions(
        int $tenantId,
        int $customerId,
        int $perPage = 15,
    ): \Illuminate\Contracts\Pagination\LengthAwarePaginator;

    public function lock(
        Wallet $wallet,
    ): Wallet;

    public function updateBalance(
        Wallet $wallet,
        float $balance,
    ): bool;

    public function createTransaction(
        array $data,
    ): WalletTransaction;
}
