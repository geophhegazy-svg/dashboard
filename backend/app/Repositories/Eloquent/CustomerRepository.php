<?php

declare(strict_types=1);

namespace App\Repositories\Eloquent;

use App\Contracts\Repositories\CustomerRepositoryInterface;
use App\Models\Customer;
use Illuminate\Database\Eloquent\Collection;

class CustomerRepository implements CustomerRepositoryInterface
{
    public function all(): Collection
    {
        return Customer::all();
    }

    public function find(int $id): ?Customer
    {
        return Customer::find($id);
    }

    public function save(Customer $customer): bool
    {
        return $customer->save();
    }

    public function delete(Customer $customer): bool
    {
        return (bool) $customer->delete();
    }
}
