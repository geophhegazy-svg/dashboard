<?php

declare(strict_types=1);

namespace App\Modules\Inventory\Infrastructure\Repositories;

use App\Modules\Inventory\Domain\Contracts\DeviceAssignmentRepositoryInterface;
use App\Modules\Inventory\Infrastructure\Persistence\Models\DeviceAssignment;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

final class DeviceAssignmentRepository implements DeviceAssignmentRepositoryInterface
{
    public function paginate(): LengthAwarePaginator
    {
        return DeviceAssignment::latest()->paginate();
    }

    public function find(int $id): ?DeviceAssignment
    {
        return DeviceAssignment::find($id);
    }

    public function create(array $data): DeviceAssignment
    {
        return DeviceAssignment::create($data);
    }

    public function update(
        DeviceAssignment $assignment,
        array $data
    ): DeviceAssignment {
        $assignment->update($data);

        return $assignment->fresh();
    }

    public function delete(DeviceAssignment $assignment): bool
    {
        return (bool) $assignment->delete();
    }
}
