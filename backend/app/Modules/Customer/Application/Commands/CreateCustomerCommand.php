<?php

declare(strict_types=1);

namespace App\Modules\Customer\Application\Commands;

use App\Core\CommandBus\Contracts\CommandInterface;

final readonly class CreateCustomerCommand implements CommandInterface
{
    public function __construct(
        public array $data,
    ) {}
}
