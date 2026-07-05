<?php

declare(strict_types=1);

namespace App\Services\Documentation\Reflection;

use ReflectionClass;
use ReflectionProperty;

class PropertyReflector
{
    public function reflect(string $class): array
    {
        $reflection = new ReflectionClass($class);

        return collect(
            $reflection->getProperties()
        )
            ->map(function (ReflectionProperty $property) {

                return [

                    'name' => $property->getName(),

                    'type' => $property->hasType()
                        ? (string) $property->getType()
                        : 'mixed',

                ];
            })
            ->values()
            ->toArray();
    }
}
