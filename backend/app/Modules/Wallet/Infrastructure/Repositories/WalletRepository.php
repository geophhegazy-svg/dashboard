<?php

declare(strict_types=1);

namespace App\Modules\Wallet\Infrastructure\Repositories;

use App\Modules\Wallet\Domain\Contracts\WalletRepositoryInterface;
use App\Modules\Wallet\Infrastructure\Persistence\Models\Wallet;
use App\Modules\Wallet\Infrastructure\Persistence\Models\WalletTransaction;

final class WalletRepository implements WalletRepositoryInterface
{
    public function findByCustomerId(
        int $tenantId,
        int $customerId,
    ): ?Wallet {
        return Wallet::query()
            ->where('tenant_id', $tenantId)
            ->where('customer_id', $customerId)
            ->first();
    }

    public function create(
        array $data,
    ): Wallet {
        return Wallet::create($data);
    }

    public function paginateTransactions(
        int $tenantId,
        int $customerId,
        int $perPage = 15,
    ): \Illuminate\Contracts\Pagination\LengthAwarePaginator {
        return WalletTransaction::query()
            ->where('tenant_id', $tenantId)
            ->where('customer_id', $customerId)
            ->latest('id')
            ->paginate($perPage);
    }

    public function lock(
        Wallet $wallet,
    ): Wallet {
        return Wallet::query()
            ->where('tenant_id', $wallet->tenant_id)
            ->lockForUpdate()
            ->findOrFail($wallet->id);
    }

    public function updateBalance(
        Wallet $wallet,
        float $balance,
    ): bool {
        return $wallet->update([
            'balance' => $balance,
        ]);
    }

    public function createTransaction(
        array $data,
    ): WalletTransaction {
        return WalletTransaction::create($data);
    }
}
