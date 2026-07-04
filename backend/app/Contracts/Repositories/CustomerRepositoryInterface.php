<?php

declare(strict_types=1);

namespace App\Contracts\Repositories;

use App\Models\Customer;
use Illuminate\Database\Eloquent\Collection;

interface CustomerRepositoryInterface
{
    public function all(): Collection;

    public function find(int $id): ?Customer;

    public function save(Customer $customer): bool;

    public function delete(Customer $customer): bool;
}
