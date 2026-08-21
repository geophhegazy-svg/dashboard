<?php

declare(strict_types=1);

namespace App\Modules\Inventory\Application\Commands\Handlers;

use App\Modules\Inventory\Application\Actions\AssignDeviceAction;
use App\Modules\Inventory\Application\Commands\AssignDeviceCommand;
use App\Modules\Inventory\Infrastructure\Persistence\Models\DeviceAssignment;

final readonly class AssignDeviceCommandHandler
{
    public function __construct(
        private AssignDeviceAction $action,
    ) {}

    public function handle(
        AssignDeviceCommand $command,
    ): DeviceAssignment {
        return $this->action->execute($command->data);
    }
}
