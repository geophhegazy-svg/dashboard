<?php

declare(strict_types=1);

namespace App\Modules\Package\Domain\Contracts;

use App\Models\Package;
use Illuminate\Database\Eloquent\Collection;

interface PackageRepositoryInterface
{
    public function all(): Collection;

    public function find(int $id): ?Package;

    public function save(Package $package): bool;

    public function delete(Package $package): bool;
}
