<?php

declare(strict_types=1);

namespace App\Modules\Package\Application\Actions;

use App\Modules\Package\Infrastructure\Persistence\Models\Package;
use App\Modules\Package\Domain\Contracts\PackageRepositoryInterface;

final readonly class UpdatePackageAction
{
    public function __construct(
        private PackageRepositoryInterface $repository,
    ) {}

    public function execute(
        Package $package,
        array $attributes,
    ): Package {

        return $this->repository->update(
            $package,
            $attributes,
        );
    }
}
