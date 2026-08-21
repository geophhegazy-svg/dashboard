<?php

declare(strict_types=1);

namespace App\Modules\Inventory\Application\Commands\Handlers;

use App\Modules\Inventory\Application\Actions\CreateDeviceAction;
use App\Modules\Inventory\Application\Commands\CreateDeviceCommand;
use App\Modules\Inventory\Infrastructure\Persistence\Models\Device;

final readonly class CreateDeviceCommandHandler
{
    public function __construct(
        private CreateDeviceAction $action,
    ) {}

    public function handle(
        CreateDeviceCommand $command,
    ): Device {
        return $this->action->execute($command->data);
    }
}
