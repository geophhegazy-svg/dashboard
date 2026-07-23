<?php

declare(strict_types=1);

namespace App\Modules\Customer\Application\Actions;

use App\Models\Customer;

final class DeleteCustomerAction
{
    public function execute(
        Customer $customer,
    ): bool {

        return (bool) $customer->delete();
    }
}
