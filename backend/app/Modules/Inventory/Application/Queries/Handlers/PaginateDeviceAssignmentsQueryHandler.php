<?php

declare(strict_types=1);

namespace App\Modules\Inventory\Application\Queries\Handlers;

use App\Modules\Inventory\Application\Queries\PaginateDeviceAssignmentsQuery;
use App\Modules\Inventory\Domain\Contracts\DeviceAssignmentRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

final readonly class PaginateDeviceAssignmentsQueryHandler
{
    public function __construct(
        private DeviceAssignmentRepositoryInterface $repository,
    ) {}

    public function handle(
        PaginateDeviceAssignmentsQuery $query,
    ): LengthAwarePaginator {
        return $this->repository->paginate();
    }
}
