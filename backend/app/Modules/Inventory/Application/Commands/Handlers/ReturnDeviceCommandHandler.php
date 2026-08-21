<?php

declare(strict_types=1);

namespace App\Modules\Inventory\Application\Commands\Handlers;

use App\Modules\Inventory\Application\Actions\ReturnDeviceAction;
use App\Modules\Inventory\Application\Commands\ReturnDeviceCommand;

final readonly class ReturnDeviceCommandHandler
{
    public function __construct(
        private ReturnDeviceAction $action,
    ) {}

    public function handle(
        ReturnDeviceCommand $command,
    ): void {
        $this->action->execute($command->assignment);
    }
}
