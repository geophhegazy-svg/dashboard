<?php

declare(strict_types=1);

namespace App\Modules\Customer\Application\Commands\Handlers;

use App\Modules\Customer\Application\Commands\DeleteCustomerCommand;
use App\Modules\Customer\Application\Actions\DeleteCustomerAction;

final readonly class DeleteCustomerCommandHandler
{
    public function __construct(
        private DeleteCustomerAction $action,
    ) {}

    public function handle(
        DeleteCustomerCommand $command,
    ): bool {
        return $this->action->execute(
            $command->customer,
        );
    }
}
