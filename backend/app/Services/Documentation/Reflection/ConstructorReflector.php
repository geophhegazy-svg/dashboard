<?php

declare(strict_types=1);

namespace App\Services\Documentation\Reflection;

use ReflectionClass;

class ConstructorReflector
{
    public function reflect(string $class): array
    {
        $reflection = new ReflectionClass($class);

        $constructor = $reflection->getConstructor();

        if (!$constructor) {
            return [];
        }

        return collect($constructor->getParameters())

            ->map(function ($parameter) {

                return [

                    'name' => $parameter->getName(),

                    'type' => $parameter->hasType()
                        ? (string) $parameter->getType()
                        : 'mixed',

                ];
            })

            ->values()

            ->toArray();
    }
}
