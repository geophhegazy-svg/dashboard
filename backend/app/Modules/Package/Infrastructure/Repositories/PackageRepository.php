<?php

declare(strict_types=1);

namespace App\Modules\Package\Infrastructure\Repositories;

use App\Modules\Package\Infrastructure\Persistence\Models\Package;
use App\Modules\Package\Domain\Contracts\PackageRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class PackageRepository implements PackageRepositoryInterface
{
    public function paginate(): LengthAwarePaginator
    {
        return Package::latest()->paginate();
    }

    public function find(int $id): ?Package
    {
        return Package::find($id);
    }

    public function create(array $data): Package
    {
        return Package::create($data);
    }

    public function update(
        Package $package,
        array $data
    ): Package {

        $package->update($data);

        return $package->fresh();
    }

    public function delete(Package $package): bool
    {
        return (bool) $package->delete();
    }
}
