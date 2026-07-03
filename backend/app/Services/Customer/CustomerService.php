<?php

declare(strict_types=1);

namespace App\Services\Customer;

use App\Models\Customer;

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
}
