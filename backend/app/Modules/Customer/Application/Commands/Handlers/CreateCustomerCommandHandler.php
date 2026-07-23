<?php

declare(strict_types=1);

namespace App\Modules\Customer\Application\Commands\Handlers;

use App\Models\Customer;
use App\Modules\Customer\Application\Commands\CreateCustomerCommand;
use App\Modules\Customer\Application\Workflows\CreateCustomerWorkflow;

final readonly class CreateCustomerCommandHandler
{
    public function __construct(
        private CreateCustomerWorkflow $workflow,
    ) {}

    public function handle(
        CreateCustomerCommand $command,
    ): Customer {

        return $this->workflow->execute(
            new Customer(
                $command->data,
            )
        );
    }
}
