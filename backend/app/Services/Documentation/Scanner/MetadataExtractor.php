<?php

declare(strict_types=1);

namespace App\Services\Documentation\Scanner;

use ReflectionClass;
use ReflectionMethod;

class MetadataExtractor
{
    public function extract(string $class): array
    {
        $reflection = new ReflectionClass($class);

        $methods = array_map(
            fn(ReflectionMethod $method) => $method->getName(),
            $reflection->getMethods(ReflectionMethod::IS_PUBLIC)
        );

        sort($methods);

        return [
            'name'       => $reflection->getShortName(),
            'class'      => $reflection->getName(),
            'namespace'  => $reflection->getNamespaceName(),
            'file'       => $reflection->getFileName(),
            'methods'    => $methods,
        ];
    }
}
