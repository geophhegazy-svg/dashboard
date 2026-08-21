<?php

declare(strict_types=1);

namespace App\Modules\Inventory\Application\Actions;

use App\Modules\Inventory\Domain\Contracts\DeviceAssignmentRepositoryInterface;
use App\Modules\Inventory\Infrastructure\Persistence\Models\DeviceAssignment;

final readonly class DeleteDeviceAssignmentAction
{
    public function __construct(
        private DeviceAssignmentRepositoryInterface $repository,
    ) {}

    public function execute(DeviceAssignment $assignment): bool
    {
        return $this->repository->delete($assignment);
    }
}
