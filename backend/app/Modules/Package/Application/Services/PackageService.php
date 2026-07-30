<?php

declare(strict_types=1);

namespace App\Modules\Package\Application\Services;

use App\Models\Package;
use App\Modules\Package\Domain\Contracts\PackageRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class PackageService
{
    public function __construct(
        private readonly PackageRepositoryInterface $repository,
    ) {}

    public function paginate(): LengthAwarePaginator
    {
        return $this->repository->paginate();
    }

    public function create(array $data): Package
    {
        return $this->repository->create($data);
    }

    public function update(
        Package $package,
        array $data
    ): Package {

        return $this->repository->update(
            $package,
            $data
        );
    }

    public function delete(
        Package $package,
    ): void {

        $this->repository->delete($package);
    }
}
