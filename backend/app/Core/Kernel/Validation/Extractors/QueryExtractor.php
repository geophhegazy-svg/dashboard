<?php

declare(strict_types=1);

namespace App\Core\Kernel\Validation\Extractors;

use App\Core\Kernel\Contracts\ModuleContract;
use App\Core\Kernel\Resources\QueryResource;

final class QueryExtractor implements ResourceExtractorInterface
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

            if (! $resource instanceof QueryResource) {
                continue;
            }

            foreach (
                array_keys($resource->compile()['queries'])
                as $query
            ) {

                yield $query;
            }
        }
    }
}
