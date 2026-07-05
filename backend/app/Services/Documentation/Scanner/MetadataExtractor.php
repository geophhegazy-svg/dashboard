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

        $file = $reflection->getFileName();

        return [

            'name' => $reflection->getShortName(),

            'class' => $reflection->getName(),

            'namespace' => $reflection->getNamespaceName(),

            // الاسم الجديد الموحد
            'path' => $file,

            // للإبقاء على التوافق مع الكود القديم
            'file' => $file,

            'filename' => basename($file),

            'methods' => $methods,
        ];
    }
}
