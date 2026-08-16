<?php

declare(strict_types=1);

namespace App\Modules\Package\Kernel;

use App\Core\Kernel\ModuleManifest;
use App\Core\Kernel\Modules\Module;
use App\Modules\Package\Domain\Contracts\PackageRepositoryInterface;
use App\Modules\Package\Infrastructure\Repositories\PackageRepository;

use App\Modules\Package\Application\Actions\CreatePackageAction;
use App\Modules\Package\Application\Actions\UpdatePackageAction;
use App\Modules\Package\Application\Actions\DeletePackageAction;

use App\Modules\Package\Infrastructure\Persistence\Models\Package;
use App\Modules\Policies\PackagePolicy;

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

                CreatePackageAction::class
                => CreatePackageAction::class,

                UpdatePackageAction::class
                => UpdatePackageAction::class,

                DeletePackageAction::class
                => DeletePackageAction::class,

            ])

            ->policies([

                Package::class => PackagePolicy::class,

            ]);
    }
}
