<?php

declare(strict_types=1);

namespace App\Modules\Customer\Application\Commands\Handlers;

use App\Modules\Customer\Application\Commands\UpdateCustomerCommand;
use App\Modules\Customer\Application\Actions\UpdateCustomerAction;
use App\Modules\Customer\Infrastructure\Persistence\Models\Customer;

final readonly class UpdateCustomerCommandHandler
{
    public function __construct(
        private UpdateCustomerAction $action,
    ) {}

    public function handle(
        UpdateCustomerCommand $command,
    ): Customer {
        return $this->action->execute(
            $command->customer,
            $command->data,
        );
    }
}
