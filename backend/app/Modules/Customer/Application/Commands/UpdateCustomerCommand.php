<?php

declare(strict_types=1);

namespace App\Modules\Customer\Application\Commands;

use App\Core\CommandBus\Contracts\CommandInterface;
use App\Modules\Customer\Infrastructure\Persistence\Models\Customer;

final readonly class UpdateCustomerCommand implements CommandInterface
{
    public function __construct(
        public Customer $customer,
        public array $data,
    ) {}
}
