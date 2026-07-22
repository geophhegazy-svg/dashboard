<?php

declare(strict_types=1);

namespace App\Core\Kernel;

use Illuminate\Console\Application as Artisan;
use Illuminate\Console\Scheduling\Schedule;
use App\Core\Kernel\Resources\CommandResource;
use App\Core\Kernel\Resources\ScheduleResource;

final class ModuleBootstrapper
{
    public function boot(
        ModuleRegistry $registry
    ): void {

        foreach ($registry->all() as $module) {

            $manifest = $module->manifest();

            foreach ($manifest->resources() as $resource) {

                $resource->register();

                if ($resource instanceof CommandResource) {

                    Artisan::starting(
                        function (Artisan $artisan) use ($resource) {

                            $artisan->resolveCommands(
                                $resource->commands()
                            );
                        }
                    );
                }

                if (
                    $resource instanceof ScheduleResource &&
                    app()->bound(Schedule::class)
                ) {

                    $resource->register();
                }
            }
        }
    }
}
