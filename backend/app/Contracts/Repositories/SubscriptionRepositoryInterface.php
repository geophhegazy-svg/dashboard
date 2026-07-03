<?php

declare(strict_types=1);

namespace App\Contracts\Repositories;

use App\Models\Subscription;
use Illuminate\Database\Eloquent\Collection;

interface SubscriptionRepositoryInterface
{
    public function find(int $id): ?Subscription;

    public function save(Subscription $subscription): bool;

    public function delete(Subscription $subscription): bool;

    public function all(): Collection;
}
