<?php

declare(strict_types=1);

namespace App\Modules\Inventory\Application\Commands\Handlers;

use App\Modules\Inventory\Application\Actions\UpdateInventoryAction;
use App\Modules\Inventory\Application\Commands\UpdateInventoryCommand;
use App\Modules\Inventory\Infrastructure\Persistence\Models\Inventory;

final readonly class UpdateInventoryCommandHandler
{
    public function __construct(
        private UpdateInventoryAction $action,
    ) {}

    public function handle(
        UpdateInventoryCommand $command,
    ): Inventory {
        return $this->action->execute(
            $command->inventory,
            $command->data,
        );
    }
}
