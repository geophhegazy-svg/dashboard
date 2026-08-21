<?php

declare(strict_types=1);

namespace App\Modules\Inventory\Application\Commands\Handlers;

use App\Modules\Inventory\Application\Actions\UpdateDeviceAssignmentAction;
use App\Modules\Inventory\Application\Commands\UpdateDeviceAssignmentCommand;
use App\Modules\Inventory\Infrastructure\Persistence\Models\DeviceAssignment;

final readonly class UpdateDeviceAssignmentCommandHandler
{
    public function __construct(
        private UpdateDeviceAssignmentAction $action,
    ) {}

    public function handle(
        UpdateDeviceAssignmentCommand $command,
    ): DeviceAssignment {
        return $this->action->execute(
            $command->assignment,
            $command->data,
        );
    }
}
