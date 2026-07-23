<?php

declare(strict_types=1);

namespace App\Modules\Customer\Application\Actions;

use App\Models\Customer;

final class UpdateCustomerAction
{
    public function execute(
        Customer $customer,
        array $data,
    ): Customer {

        $customer->update($data);

        return $customer->refresh();
    }
}
