<?php

declare(strict_types=1);

namespace App\Modules\Notification\Kernel;

use App\Core\Kernel\ModuleManifest;
use App\Core\Kernel\Modules\Module;
use App\Modules\Notification\Domain\Contracts\NotificationRepositoryInterface;
use App\Modules\Notification\Infrastructure\Repositories\NotificationRepository;

final class NotificationModule extends Module
{
    public function name(): string
    {
        return 'Notification';
    }

    public function dependencies(): array
    {
        return [];
    }

    public function manifest(): ModuleManifest
    {
        return ModuleManifest::make()

            ->services([

                NotificationRepositoryInterface::class
                => NotificationRepository::class,

            ]);
    }

    
}
