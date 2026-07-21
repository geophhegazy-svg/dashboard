<?php

declare(strict_types=1);

namespace App\Modules\Customer\Application\Services;

use App\Models\Customer;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class CustomerService
{
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
        return $customer->delete();
    }

    public function paginate(): LengthAwarePaginator
    {
        return Customer::latest()->paginate();
    }
}
