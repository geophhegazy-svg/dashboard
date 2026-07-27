<?php

declare(strict_types=1);

namespace App\Core\Kernel\Validation;

use App\Core\Kernel\Contracts\ModuleResourceInterface;
use App\Core\Kernel\ModuleRegistry;

final class ResourceCollector
{
    /**
     * @return list<ModuleResourceInterface>
     */
    public function collect(
        ModuleRegistry $registry,
    ): array {

        $resources = [];

        foreach ($registry->all() as $module) {

            foreach (
                $module
                    ->manifest()
                    ->resources()
                    ->all()
                as $resource
            ) {

                $resources[] = $resource;
            }
        }

        return $resources;
    }
}
