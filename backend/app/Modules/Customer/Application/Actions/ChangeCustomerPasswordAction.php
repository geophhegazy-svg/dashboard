<?php

declare(strict_types=1);

namespace App\Modules\Customer\Application\Actions;

use App\Modules\Customer\Infrastructure\Persistence\Models\Customer;
use Illuminate\Support\Facades\Hash;

final readonly class ChangeCustomerPasswordAction
{
    public function execute(
        Customer $customer,
        string $newPassword,
    ): Customer {
        $customer->update([
            'password' => Hash::make($newPassword),
        ]);

        return $customer->refresh();
    }
}
