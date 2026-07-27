<?php

declare(strict_types=1);

namespace App\Core\Kernel\Validation;

use App\Core\Kernel\ModuleRegistry;
use App\Core\Kernel\Validation\Extractors\ResourceExtractorInterface;

final class DuplicateResourceDetector
{
    /**
     * @return list<ValidationError>
     */
    public function detect(
        ModuleRegistry $registry,
        ResourceExtractorInterface $extractor,
        ValidationErrorCode $code,
        string $resourceName,
    ): array {

        $registered = [];

        $errors = [];

        foreach ($registry->all() as $module) {

            foreach ($extractor->extract($module) as $identifier) {

                if (! isset($registered[$identifier])) {

                    $registered[$identifier] = $module->name();

                    continue;
                }

                $errors[] = new ValidationError(
                    $code,
                    sprintf(
                        '%s [%s] is registered by both [%s] and [%s].',
                        $resourceName,
                        $identifier,
                        $registered[$identifier],
                        $module->name(),
                    ),
                );
            }
        }

        return $errors;
    }
}
