<?php

declare(strict_types=1);

namespace App\Core\Kernel\Validation\Extractors;

use App\Core\Kernel\Contracts\ModuleContract;
use App\Core\Kernel\Resources\CommandResource;

final class CommandExtractor implements ResourceExtractorInterface
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

            if (! $resource instanceof CommandResource) {
                continue;
            }

            foreach ($resource->compile()['commands'] as $command) {
                yield $command;
            }
        }
    }
}
