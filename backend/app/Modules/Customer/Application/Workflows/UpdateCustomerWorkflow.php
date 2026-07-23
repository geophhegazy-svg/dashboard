<?php

declare(strict_types=1);

namespace App\Modules\Customer\Application\Workflows;

use App\Models\Customer;
use App\Modules\Customer\Application\Actions\UpdateCustomerAction;

final readonly class UpdateCustomerWorkflow
{
    public function __construct(
        private UpdateCustomerAction $updateCustomer,
    ) {}

    public function execute(
        Customer $customer,
        array $data,
    ): Customer {
        return $this->updateCustomer->execute(
            $customer,
            $data,
        );
    }
}
