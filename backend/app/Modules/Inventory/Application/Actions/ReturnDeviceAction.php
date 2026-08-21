<?php

declare(strict_types=1);

namespace App\Modules\Inventory\Application\Actions;

use App\Modules\Inventory\Domain\Contracts\DeviceAssignmentRepositoryInterface;
use App\Modules\Inventory\Domain\Contracts\InventoryRepositoryInterface;
use App\Modules\Inventory\Infrastructure\Persistence\Models\DeviceAssignment;
use Illuminate\Support\Facades\DB;

final readonly class ReturnDeviceAction
{
    public function __construct(
        private DeviceAssignmentRepositoryInterface $assignmentRepository,
        private InventoryRepositoryInterface $inventoryRepository,
    ) {}

    public function execute(
        DeviceAssignment $assignment,
    ): void {
        DB::transaction(function () use ($assignment): void {

            if ($assignment->status === 'returned') {
                abort(422, 'Device already returned');
            }

            $this->assignmentRepository->update(
                $assignment,
                [
                    'status'      => 'returned',
                    'returned_at' => now(),
                ],
            );

            $device = $assignment->device;

            $inventory = $this->inventoryRepository->findByDevice(
                $assignment->tenant_id,
                $device->device_type,
                $device->brand,
                $device->model,
            );

            if ($inventory) {
                $this->inventoryRepository->incrementQuantity(
                    $inventory,
                );
            }
        });
    }
}
