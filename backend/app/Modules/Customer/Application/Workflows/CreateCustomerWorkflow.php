<?php

declare(strict_types=1);

namespace App\Modules\Customer\Application\Workflows;

use App\Models\Customer;
use App\Modules\Customer\Application\Actions\CreateCustomerAction;

final readonly class CreateCustomerWorkflow
{
    public function __construct(
        private CreateCustomerAction $createCustomer,
    ) {}

    public function execute(Customer $customer): Customer
    {
        return $this->createCustomer->execute(
            $customer
        );
    }
}
