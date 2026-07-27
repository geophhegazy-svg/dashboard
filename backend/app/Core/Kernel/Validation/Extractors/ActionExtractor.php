<?php

declare(strict_types=1);

namespace App\Core\Kernel\Validation\Extractors;

use App\Core\Kernel\Contracts\ModuleContract;
use App\Core\Kernel\Resources\ActionResource;

final class ActionExtractor implements ResourceExtractorInterface
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

            if (! $resource instanceof ActionResource) {
                continue;
            }

            foreach ($resource->compile()['actions'] as $action) {
                yield $action;
            }
        }
    }
}

