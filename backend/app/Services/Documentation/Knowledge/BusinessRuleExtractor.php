<?php

declare(strict_types=1);

namespace App\Services\Documentation\Knowledge;

use ReflectionClass;

class BusinessRuleExtractor
{
    public function extract(array $service): array
    {
        $class = $service['class'];

        $reflection = new \ReflectionClass($class);

        $dependencies = [];

        if ($constructor = $reflection->getConstructor()) {
            foreach ($constructor->getParameters() as $parameter) {
                $type = $parameter->getType();

                if ($type instanceof \ReflectionNamedType && ! $type->isBuiltin()) {
                    $dependencies[] = $type->getName();
                }
            }
        }

        $methods = [];

        foreach ($reflection->getMethods(\ReflectionMethod::IS_PUBLIC) as $method) {

            if ($method->class !== $class) {
                continue;
            }

            $methods[] = [
                'name' => $method->getName(),
                'parameters' => count($method->getParameters()),
                'return_type' => $method->hasReturnType()
                    ? (string) $method->getReturnType()
                    : null,
            ];
        }

        return [
            'class' => $reflection->getShortName(),
            'namespace' => $reflection->getNamespaceName(),
            'dependencies' => $dependencies,
            'methods' => $methods,
        ];
    }
}
