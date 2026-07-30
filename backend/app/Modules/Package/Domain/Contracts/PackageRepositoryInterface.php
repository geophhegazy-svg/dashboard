<?php

declare(strict_types=1);

namespace App\Modules\Package\Domain\Contracts;

use App\Models\Package;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface PackageRepositoryInterface
{
    public function paginate(): LengthAwarePaginator;

    public function find(int $id): ?Package;

    public function create(array $data): Package;

    public function update(
        Package $package,
        array $data
    ): Package;

    public function delete(Package $package): bool;
}
