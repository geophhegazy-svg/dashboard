<?php

declare(strict_types=1);

namespace App\Modules\Customer\Domain\Contracts;

use App\Models\Customer;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface CustomerRepositoryInterface
{
    public function all(): Collection;

    public function paginate(
        int $perPage = 15,
    ): LengthAwarePaginator;

    public function find(int $id): ?Customer;

    public function save(Customer $customer): bool;

    public function delete(Customer $customer): bool;

}
