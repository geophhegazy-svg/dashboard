<?php

declare(strict_types=1);

namespace App\Modules\Customer\Application\Workflows;

use App\Models\Customer;
use App\Modules\Customer\Application\Actions\DeleteCustomerAction;

final readonly class DeleteCustomerWorkflow
{
    public function __construct(
        private DeleteCustomerAction $deleteCustomer,
    ) {}

    public function execute(
        Customer $customer,
    ): bool {

        return $this->deleteCustomer->execute(
            $customer,
        );
    }
}
