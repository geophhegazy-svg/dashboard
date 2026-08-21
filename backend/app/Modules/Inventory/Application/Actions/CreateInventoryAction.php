<?php

declare(strict_types=1);

namespace App\Modules\Inventory\Application\Actions;

use App\Modules\Inventory\Domain\Contracts\InventoryRepositoryInterface;
use App\Modules\Inventory\Infrastructure\Persistence\Models\Inventory;

final readonly class CreateInventoryAction
{
    public function __construct(
        private InventoryRepositoryInterface $repository,
    ) {}

    public function execute(array $data): Inventory
    {
        return $this->repository->create($data);
    }
}
