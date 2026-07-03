<?php

declare(strict_types=1);

namespace App\Services\Customer;

use App\Models\Customer;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class CustomerService
{
    public function paginate(): LengthAwarePaginator
    {
        return Customer::latest()->paginate();
    }

    public function create(array $data): Customer
    {
        return Customer::create($data);
    }

    public function update(Customer $customer, array $data): Customer
    {
        $customer->update($data);

        return $customer->refresh();
    }

    public function delete(Customer $customer): bool
    {
        return (bool) $customer->delete();
    }
}
