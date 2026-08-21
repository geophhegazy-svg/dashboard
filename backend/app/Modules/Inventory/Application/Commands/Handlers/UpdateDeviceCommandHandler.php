<?php

declare(strict_types=1);

namespace App\Modules\Inventory\Application\Commands\Handlers;

use App\Modules\Inventory\Application\Actions\UpdateDeviceAction;
use App\Modules\Inventory\Application\Commands\UpdateDeviceCommand;
use App\Modules\Inventory\Infrastructure\Persistence\Models\Device;

final readonly class UpdateDeviceCommandHandler
{
    public function __construct(
        private UpdateDeviceAction $action,
    ) {}

    public function handle(
        UpdateDeviceCommand $command,
    ): Device {
        return $this->action->execute(
            $command->device,
            $command->data,
        );
    }
}
