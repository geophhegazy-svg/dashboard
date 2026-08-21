<?php

declare(strict_types=1);

namespace App\Modules\Inventory\Application\Actions;

use App\Modules\Inventory\Domain\Contracts\DeviceAssignmentRepositoryInterface;
use App\Modules\Inventory\Domain\Contracts\DeviceRepositoryInterface;
use App\Modules\Inventory\Domain\Contracts\InventoryRepositoryInterface;
use App\Modules\Inventory\Infrastructure\Persistence\Models\DeviceAssignment;
use Illuminate\Support\Facades\DB;

final readonly class AssignDeviceAction
{
    public function __construct(
        private DeviceRepositoryInterface $deviceRepository,
        private InventoryRepositoryInterface $inventoryRepository,
        private DeviceAssignmentRepositoryInterface $assignmentRepository,
    ) {}

    public function execute(array $data): DeviceAssignment
    {
        return DB::transaction(function () use ($data): DeviceAssignment {
            $device = $this->deviceRepository->findOrFail(
                $data['device_id'],
            );

            $inventory = $this->inventoryRepository->findByDevice(
                $data['tenant_id'],
                $device->device_type,
                $device->brand,
                $device->model,
            );

            if ($inventory && $inventory->quantity > 0) {
                $this->inventoryRepository->decrementQuantity(
                    $inventory,
                );
            }

            return $this->assignmentRepository->create($data);
        });
    }
}
