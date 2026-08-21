<?php

declare(strict_types=1);

namespace App\Modules\Inventory\Application\Commands\Handlers;

use App\Modules\Inventory\Application\Actions\CreateInventoryAction;
use App\Modules\Inventory\Application\Commands\CreateInventoryCommand;
use App\Modules\Inventory\Infrastructure\Persistence\Models\Inventory;

final readonly class CreateInventoryCommandHandler
{
    public function __construct(
        private CreateInventoryAction $action,
    ) {}

    public function handle(
        CreateInventoryCommand $command,
    ): Inventory {
        return $this->action->execute($command->data);
    }
}
