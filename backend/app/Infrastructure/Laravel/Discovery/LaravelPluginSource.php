<?php

declare(strict_types=1);

namespace App\Infrastructure\Laravel\Discovery;

use App\Core\Kernel\Discovery\Contracts\PluginSourceInterface;
use App\Core\Kernel\Plugins\Plugin;
use Illuminate\Support\Facades\File;

final class LaravelPluginSource implements PluginSourceInterface
{
    /**
     * @return iterable<Plugin>
     */
    public function plugins(): iterable
    {
        $pluginsPath = app_path('Plugins');


        if (! File::exists($pluginsPath)) {
            return [];
        }


        foreach (File::directories($pluginsPath) as $directory) {

            $plugin = basename($directory);


            $class = sprintf(
                'App\\Plugins\\%s\\%sPlugin',
                $plugin,
                $plugin
            );


            if (! class_exists($class)) {
                continue;
            }


            $instance = app($class);


            if ($instance instanceof Plugin) {
                yield $instance;
            }
        }
    }
}
