<?php

declare(strict_types=1);

namespace App\Modules\Package\Kernel;

use App\Core\Kernel\ModuleManifest;
use App\Core\Kernel\Modules\Module;
use App\Modules\Package\Domain\Contracts\PackageRepositoryInterface;
use App\Modules\Package\Infrastructure\Repositories\PackageRepository;

final class PackageModule extends Module
{
    public function name(): string
    {
        return 'Package';
    }

    public function dependencies(): array
    {
        return [];
    }

    public function manifest(): ModuleManifest
    {
        return ModuleManifest::make()

            ->services([

                PackageRepositoryInterface::class
                => PackageRepository::class,

            ]);
    }
}
