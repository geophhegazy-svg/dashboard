<?php

namespace App\Contracts\Repositories;

use App\Models\Subscription;
use Illuminate\Pagination\LengthAwarePaginator;

interface SubscriptionRepositoryInterface
{
    public function getAll(array $filters = [], int $perPage = 15): LengthAwarePaginator;
    public function findById(int $id): ?Subscription;
    public function getByCustomerId(int $customerId): array;
    public function getActiveSubscriptions(): array;
    public function getExpiredSubscriptions(): array;
    public function create(array $data): Subscription;
    public function update(int $id, array $data): Subscription;
    public function delete(int $id): bool;
    public function renew(int $id, int $months): Subscription;
    public function cancel(int $id): bool;
}
