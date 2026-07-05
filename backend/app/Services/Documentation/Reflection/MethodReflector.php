<?php

declare(strict_types=1);

namespace App\Services\Documentation\Reflection;

use ReflectionClass;
use ReflectionMethod;

class MethodReflector
{
    public function reflect(string $class): array
    {
        $reflection = new ReflectionClass($class);

        return collect(
            $reflection->getMethods(ReflectionMethod::IS_PUBLIC)
        )
            ->reject(fn(ReflectionMethod $method) => $method->isConstructor())
            ->reject(fn(ReflectionMethod $method) => $method->class !== $class)
            ->map(function (ReflectionMethod $method) {

                return [
                    'name' => $method->getName(),

                    'return' => $method->hasReturnType()
                        ? (string) $method->getReturnType()
                        : 'mixed',

                    'parameters' => collect($method->getParameters())
                        ->map(function ($parameter) {

                            return [

                                'name' => $parameter->getName(),

                                'type' => $parameter->hasType()
                                    ? (string) $parameter->getType()
                                    : 'mixed',

                            ];
                        })
                        ->values()
                        ->toArray(),
                ];
            })
            ->values()
            ->toArray();
    }
}
