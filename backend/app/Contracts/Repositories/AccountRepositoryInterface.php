<?php

declare(strict_types=1);

namespace App\Contracts\Repositories;

use App\Models\Account;
use Illuminate\Database\Eloquent\Collection;

interface AccountRepositoryInterface
{
    public function all(): Collection;

    public function find(int $id): ?Account;

    public function findByCode(string $code): ?Account;

    public function create(array $data): Account;

    public function update(Account $account, array $data): Account;

    public function delete(Account $account): bool;

    public function rootAccounts(): Collection;

    public function children(Account $account): Collection;
}
