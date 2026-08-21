<?php

declare(strict_types=1);

namespace App\Modules\Inventory\Application\Commands\Handlers;

use App\Modules\Inventory\Application\Actions\DeleteDeviceAssignmentAction;
use App\Modules\Inventory\Application\Commands\DeleteDeviceAssignmentCommand;

final readonly class DeleteDeviceAssignmentCommandHandler
{
    public function __construct(
        private DeleteDeviceAssignmentAction $action,
    ) {}

    public function handle(
        DeleteDeviceAssignmentCommand $command,
    ): bool {
        return $this->action->execute($command->assignment);
    }
}
