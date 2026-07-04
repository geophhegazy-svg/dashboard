<?php

declare(strict_types=1);

namespace App\Repositories\Eloquent;

use App\Contracts\Repositories\PackageRepositoryInterface;
use App\Models\Package;
use Illuminate\Database\Eloquent\Collection;

class PackageRepository implements PackageRepositoryInterface
{
    public function all(): Collection
    {
        return Package::all();
    }

    public function find(int $id): ?Package
    {
        return Package::find($id);
    }

    public function save(Package $package): bool
    {
        return $package->save();
    }

    public function delete(Package $package): bool
    {
        return (bool) $package->delete();
    }
}
