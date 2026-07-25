<?php

declare(strict_types=1);

namespace App\Core\Kernel\Inspector;

final readonly class ModuleInformation
{
    /**
     * @param list<class-string> $dependencies
     * @param list<string> $resources
     */
    public function __construct(
        private string $class,
        private string $name,
        private array $dependencies,
        private array $resources,
    ) {}

    public function class(): string
    {
        return $this->class;
    }

    public function name(): string
    {
        return $this->name;
    }

    /**
     * @return list<class-string>
     */
    public function dependencies(): array
    {
        return $this->dependencies;
    }

    /**
     * @return list<string>
     */
    public function resources(): array
    {
        return $this->resources;
    }

    public function dependencyCount(): int
    {
        return count(
            $this->dependencies,
        );
    }

    public function resourceCount(): int
    {
        return count(
            $this->resources,
        );
    }
}
