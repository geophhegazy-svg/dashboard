<?php

declare(strict_types=1);

namespace App\Modules\Task\Kernel;

use App\Core\Kernel\ModuleManifest;
use App\Core\Kernel\Modules\Module;
use App\Modules\Task\Domain\Contracts\TaskRepositoryInterface;
use App\Modules\Task\Infrastructure\Repositories\TaskRepository;

final class TaskModule extends Module
{
    public function name(): string
    {
        return 'Task';
    }

    public function dependencies(): array
    {
        return [];
    }

    public function manifest(): ModuleManifest
    {
        return ModuleManifest::make()

            ->services([

                TaskRepositoryInterface::class
                => TaskRepository::class,

            ]);
    }
}
