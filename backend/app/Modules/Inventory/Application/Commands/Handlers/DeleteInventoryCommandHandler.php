<?php

declare(strict_types=1);

namespace App\Modules\Inventory\Application\Commands\Handlers;

use App\Modules\Inventory\Application\Actions\DeleteInventoryAction;
use App\Modules\Inventory\Application\Commands\DeleteInventoryCommand;

final readonly class DeleteInventoryCommandHandler
{
    public function __construct(
        private DeleteInventoryAction $action,
    ) {}

    public function handle(
        DeleteInventoryCommand $command,
    ): bool {
        return $this->action->execute($command->inventory);
    }
}
