<?php

declare(strict_types=1);

namespace App\Modules\Customer\Application\Commands\Handlers;

use App\Modules\Customer\Application\Commands\CreateCustomerCommand;
use App\Modules\Customer\Application\Actions\CreateCustomerAction;
use App\Modules\Customer\Infrastructure\Persistence\Models\Customer;

final readonly class CreateCustomerCommandHandler
{
    public function __construct(
        private CreateCustomerAction $action,
    ) {}

    public function handle(
        CreateCustomerCommand $command,
    ): Customer {
        return $this->action->execute(
            $command->data
        );
    }
}
