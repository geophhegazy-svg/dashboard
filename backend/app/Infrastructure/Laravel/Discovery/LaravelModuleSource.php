<?php

declare(strict_types=1);

namespace App\Infrastructure\Laravel\Discovery;

use App\Core\Kernel\Discovery\Contracts\ModuleSourceInterface;
use App\Core\Kernel\Modules\Module;
use Illuminate\Support\Facades\File;

final class LaravelModuleSource implements ModuleSourceInterface
{
    public function modules(): iterable
    {
        $modulesPath = app_path('Modules');


        if (! File::exists($modulesPath)) {
            return [];
        }


        foreach (File::directories($modulesPath) as $directory) {

            $module = basename($directory);


            $class = sprintf(
                'App\\Modules\\%s\\Kernel\\%sModule',
                $module,
                $module
            );


            if (! class_exists($class)) {
                continue;
            }


            $instance = app($class);


            if ($instance instanceof Module) {

                yield $instance;
            }
        }
    }
}
