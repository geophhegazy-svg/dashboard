<?php

declare(strict_types=1);

namespace App\Modules\Package\Application\Actions;

use App\Modules\Package\Infrastructure\Persistence\Models\Package;
use App\Modules\Package\Domain\Contracts\PackageRepositoryInterface;

final readonly class CreatePackageAction
{
    public function __construct(
        private PackageRepositoryInterface $repository,
    ) {}

    public function execute(
        array $attributes,
    ): Package {

        return $this->repository->create(
            $attributes,
        );
    }
}
