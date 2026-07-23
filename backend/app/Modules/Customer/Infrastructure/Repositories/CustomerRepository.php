<?php

declare(strict_types=1);

namespace App\Modules\Customer\Infrastructure\Repositories;

use App\Models\Customer;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use App\Modules\Customer\Domain\Contracts\CustomerRepositoryInterface;

final class CustomerRepository implements CustomerRepositoryInterface
{
    public function all(): Collection
    {
        return Customer::all();
    }

    public function paginate(
        int $perPage = 15,
    ): LengthAwarePaginator {

        return Customer::query()
            ->latest()
            ->paginate($perPage);
    }

    public function find(
        int $id,
    ): ?Customer {

        return Customer::find($id);
    }

    public function save(
        Customer $customer,
    ): bool {

        return $customer->save();
    }

    public function delete(
        Customer $customer,
    ): bool {

        return (bool) $customer->delete();
    }
}
