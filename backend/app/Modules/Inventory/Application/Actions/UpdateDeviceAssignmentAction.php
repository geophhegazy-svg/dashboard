<?php

declare(strict_types=1);

namespace App\Modules\Inventory\Application\Actions;

use App\Modules\Inventory\Domain\Contracts\DeviceAssignmentRepositoryInterface;
use App\Modules\Inventory\Infrastructure\Persistence\Models\DeviceAssignment;

final readonly class UpdateDeviceAssignmentAction
{
    public function __construct(
        private DeviceAssignmentRepositoryInterface $repository,
    ) {}

    public function execute(
        DeviceAssignment $assignment,
        array $data,
    ): DeviceAssignment {
        return $this->repository->update(
            $assignment,
            $data,
        );
    }
}
