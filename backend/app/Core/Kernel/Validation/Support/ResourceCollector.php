<?php

declare(strict_types=1);

namespace App\Core\Kernel\Validation\Support;

use App\Core\Kernel\ModuleRegistry;
use App\Core\Kernel\Resources\ServiceResource;

final class ResourceCollector
{
    public function services(
        ModuleRegistry $registry,
    ): ResourceMap {

        $map = new ResourceMap();

        foreach ($registry->all() as $module) {

            foreach (
                $module
                    ->manifest()
                    ->resources()
                    ->all()
                as $resource
            ) {

                if (! $resource instanceof ServiceResource) {
                    continue;
                }

                foreach ($resource->compile()['bindings'] as $abstract => $implementation) {

                    $map->add(
                        $abstract,
                        $module->name(),
                    );
                }
            }
        }

        return $map;
    }
}
