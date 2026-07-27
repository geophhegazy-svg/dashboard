<?php

declare(strict_types=1);

namespace App\Core\Kernel\Validation\Extractors;

use App\Core\Kernel\Contracts\ModuleContract;
use App\Core\Kernel\Resources\ServiceResource;

final class ServiceExtractor
implements ResourceExtractorInterface
{
    public function extract(
        ModuleContract $module,
    ): iterable {

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

            foreach (
                $resource->compile()['bindings']
                as $abstract => $concrete
            ) {

                yield $abstract;
            }
        }
    }
}
