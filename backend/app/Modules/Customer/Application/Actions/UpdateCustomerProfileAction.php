<?php

declare(strict_types=1);

namespace App\Modules\Customer\Application\Actions;

use App\Modules\Customer\Infrastructure\Persistence\Models\Customer;

final readonly class UpdateCustomerProfileAction
{
    public function execute(
        Customer $customer,
        array $data,
    ): Customer {
        $customer->update($data);

        return $customer->refresh();
    }
}
