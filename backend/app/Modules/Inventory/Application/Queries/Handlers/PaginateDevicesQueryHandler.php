<?php

declare(strict_types=1);

namespace App\Modules\Inventory\Application\Queries\Handlers;

use App\Modules\Inventory\Application\Queries\PaginateDevicesQuery;
use App\Modules\Inventory\Domain\Contracts\DeviceRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

final readonly class PaginateDevicesQueryHandler
{
    public function __construct(
        private DeviceRepositoryInterface $repository,
    ) {}

    public function handle(
        PaginateDevicesQuery $query,
    ): LengthAwarePaginator {
        return $this->repository->paginate();
    }
}
