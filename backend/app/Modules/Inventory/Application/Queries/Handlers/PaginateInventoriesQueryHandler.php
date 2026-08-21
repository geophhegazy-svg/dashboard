<?php

declare(strict_types=1);

namespace App\Modules\Inventory\Application\Queries\Handlers;

use App\Modules\Inventory\Application\Queries\PaginateInventoriesQuery;
use App\Modules\Inventory\Domain\Contracts\InventoryRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

final readonly class PaginateInventoriesQueryHandler
{
    public function __construct(
        private InventoryRepositoryInterface $repository,
    ) {}

    public function handle(
        PaginateInventoriesQuery $query,
    ): LengthAwarePaginator {
        return $this->repository->paginate();
    }
}
