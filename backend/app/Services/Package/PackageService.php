<?php

declare(strict_types=1);

namespace App\Services\Package;

use App\Models\Package;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class PackageService
{
    public function paginate(): LengthAwarePaginator
    {
        return Package::latest()->paginate();
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

    public function delete(
        Package $package
    ): void {

        $package->delete();
    }
}
