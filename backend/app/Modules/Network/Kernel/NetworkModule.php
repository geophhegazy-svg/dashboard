<?php

declare(strict_types=1);

namespace App\Modules\Network\Kernel;

use App\Core\Kernel\ModuleManifest;
use App\Core\Kernel\Modules\Module;
use App\Modules\Network\Application\MikrotikServiceAdapter;
use App\Modules\Network\Domain\Contracts\MikrotikServiceInterface;

final class NetworkModule extends Module
{
    public function name(): string
    {
        return 'Network';
    }

    public function dependencies(): array
    {
        return [];
    }

    public function manifest(): ModuleManifest
    {
        return ModuleManifest::make()

            ->services([

                MikrotikServiceInterface::class
                => MikrotikServiceAdapter::class,

            ]);
    }
}
