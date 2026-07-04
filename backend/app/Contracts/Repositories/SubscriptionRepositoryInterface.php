<?php

declare(strict_types=1);

namespace App\Contracts\Repositories;

use App\Models\Subscription;
use Illuminate\Database\Eloquent\Collection;

interface SubscriptionRepositoryInterface
{

    public function usernameExists(
        string $username,
        int $ignoreId = 0
    ): bool;

    public function updatePppoe(
        Subscription $subscription,
        string $username
    ): bool;
    
    public function find(int $id): ?Subscription;

    public function all(): Collection;

    public function save(Subscription $subscription): bool;

    public function delete(Subscription $subscription): bool;

    public function linkedPppoeUsers(): array;

    public function pppoeAlreadyLinked(
        string $username,
        ?int $exceptId = null
    ): bool;

    public function expiringSubscriptions(): Collection;
}
