<?php

declare(strict_types=1);

namespace App\Core\Kernel\Compiler;

final readonly class CompiledModule
{
    /**
     * @param list<class-string> $dependencies
     * @param list<array<string,mixed>> $resources
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
     * @return list<array<string,mixed>>
     */
    public function resources(): array
    {
        return $this->resources;
    }

    public function dependencyCount(): int
    {
        return count($this->dependencies);
    }

    public function resourceCount(): int
    {
        return count($this->resources);
    }

    public function hasDependencies(): bool
    {
        return $this->dependencies !== [];
    }

    public function hasResources(): bool
    {
        return $this->resources !== [];
    }

    /**
     * @return array{
     *     class: class-string,
     *     name: string,
     *     dependencies: list<class-string>,
     *     resources: list<array<string,mixed>>
     * }
     */
    public function toPayload(): array
    {
        return [
            'class' => $this->class,
            'name' => $this->name,
            'dependencies' => $this->dependencies,
            'resources' => $this->resources,
        ];
    }

    /**
     * @param array{
     *     class: class-string,
     *     name: string,
     *     dependencies: list<class-string>,
     *     resources: list<array<string,mixed>>
     * } $payload
     */
    public static function fromPayload(
        array $payload,
    ): self {
        return new self(
            class: $payload['class'],
            name: $payload['name'],
            dependencies: $payload['dependencies'],
            resources: $payload['resources'],
        );
    }
}
