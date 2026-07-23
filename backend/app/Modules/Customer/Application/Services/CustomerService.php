<?php

declare(strict_types=1);

namespace App\Modules\Customer\Application\Services;

use App\Models\Customer;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use App\Modules\Customer\Application\Actions\CreateCustomerAction;
use App\Modules\Customer\Application\Actions\UpdateCustomerAction;
use App\Modules\Customer\Application\Actions\DeleteCustomerAction;

final readonly class CustomerService
{
    public function __construct(
        private CreateCustomerAction $createCustomer,
        private UpdateCustomerAction $updateCustomer,
        private DeleteCustomerAction $deleteCustomer,
    ) {}

    public function create(array $data): Customer
    {
        $customer = new Customer($data);

        return $this->createCustomer->execute($customer);
    }

    public function update(Customer $customer, array $data): Customer
    {
        return $this->updateCustomer->execute(
            $customer,
            $data,
        );
    }

    public function delete(Customer $customer): bool
    {
        return $this->deleteCustomer->execute($customer);
    }

    public function paginate(): LengthAwarePaginator
    {
        return Customer::latest()->paginate();
    }
}
