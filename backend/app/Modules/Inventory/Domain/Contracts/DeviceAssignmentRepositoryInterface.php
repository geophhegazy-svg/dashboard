<?php

declare(strict_types=1);

namespace App\Modules\Inventory\Domain\Contracts;

use App\Modules\Inventory\Infrastructure\Persistence\Models\DeviceAssignment;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface DeviceAssignmentRepositoryInterface
{
    public function paginate(): LengthAwarePaginator;

    public function find(int $id): ?DeviceAssignment;

    public function create(array $data): DeviceAssignment;

    public function update(
        DeviceAssignment $assignment,
        array $data
    ): DeviceAssignment;

    public function delete(DeviceAssignment $assignment): bool;
}
