<?php

declare(strict_types=1);

namespace App\Services\Documentation\Reflection;

class ReflectionEngine
{
    public function __construct(
        protected MethodReflector $methods = new MethodReflector(),
        protected PropertyReflector $properties = new PropertyReflector(),
        protected ConstructorReflector $constructor = new ConstructorReflector(),
    ) {}

    public function reflect(string $class): array
    {
        return [

            'methods' => $this->methods->reflect($class),

            'properties' => $this->properties->reflect($class),

            'constructor' => $this->constructor->reflect($class),

        ];
    }
}
