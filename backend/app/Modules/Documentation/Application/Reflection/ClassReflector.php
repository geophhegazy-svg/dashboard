<?php

declare(strict_types=1);

namespace App\Modules\Documentation\Application\Reflection;

use ReflectionClass;

class ClassReflector
{
    public function methods(string $class): array
    {
        if (! class_exists($class)) {
            return [];
        }

        $reflection = new ReflectionClass($class);

        return collect($reflection->getMethods())
            ->reject(
                fn($method) =>
                $method->class !== $class
            )
            ->map(fn($method) => [
                'name' => $method->getName(),
                'public' => $method->isPublic(),
                'protected' => $method->isProtected(),
                'private' => $method->isPrivate(),
            ])
            ->values()
            ->toArray();
    }
}
