<?php

declare(strict_types=1);

namespace App\Repositories\Eloquent;

use App\Contracts\Repositories\AccountRepositoryInterface;
use App\Models\Account;
use Illuminate\Database\Eloquent\Collection;

class AccountRepository implements AccountRepositoryInterface
{
    public function all(): Collection
    {
        return Account::orderBy('code')->get();
    }

    public function find(int $id): ?Account
    {
        return Account::find($id);
    }

    public function findByCode(string $code): ?Account
    {
        return Account::where('code', $code)->first();
    }

    public function create(array $data): Account
    {
        return Account::create($data);
    }

    public function update(Account $account, array $data): Account
    {
        $account->update($data);

        return $account->fresh();
    }

    public function delete(Account $account): bool
    {
        return (bool) $account->delete();
    }

    public function rootAccounts(): Collection
    {
        return Account::whereNull('parent_id')
            ->orderBy('code')
            ->get();
    }

    public function children(Account $account): Collection
    {
        return Account::where('parent_id', $account->id)
            ->orderBy('code')
            ->get();
    }
}
