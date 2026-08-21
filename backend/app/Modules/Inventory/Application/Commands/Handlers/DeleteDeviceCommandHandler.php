<?php

declare(strict_types=1);

namespace App\Modules\Inventory\Application\Commands\Handlers;

use App\Modules\Inventory\Application\Actions\DeleteDeviceAction;
use App\Modules\Inventory\Application\Commands\DeleteDeviceCommand;

final readonly class DeleteDeviceCommandHandler
{
    public function __construct(
        private DeleteDeviceAction $action,
    ) {}

    public function handle(
        DeleteDeviceCommand $command,
    ): bool {
        return $this->action->execute($command->device);
    }
}
