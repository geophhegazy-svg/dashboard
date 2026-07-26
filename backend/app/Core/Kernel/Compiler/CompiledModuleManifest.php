<?php

declare(strict_types=1);

namespace App\Core\Kernel\Compiler;

final readonly class CompiledModuleManifest
{
    /**
     * @param list<CompiledModule> $modules
     */
    public function __construct(
        private array $modules,
    ) {}

    /**
     * @return list<CompiledModule>
     */
    public function modules(): array
    {
        return $this->modules;
    }

    public function count(): int
    {
        return count($this->modules);
    }

    public function isEmpty(): bool
    {
        return $this->modules === [];
    }

    public function hasModules(): bool
    {
        return $this->modules !== [];
    }

    public function containsClass(
        string $class,
    ): bool {
        return $this->findByClass($class) !== null;
    }

    public function containsName(
        string $name,
    ): bool {
        return $this->findByName($name) !== null;
    }

    public function findByClass(
        string $class,
    ): ?CompiledModule {

        foreach ($this->modules as $module) {

            if ($module->class() === $class) {
                return $module;
            }
        }

        return null;
    }

    public function findByName(
        string $name,
    ): ?CompiledModule {

        foreach ($this->modules as $module) {

            if ($module->name() === $name) {
                return $module;
            }
        }

        return null;
    }

    /**
     * @return array{
     *     version:int,
     *     modules:list<array{
     *         class:class-string,
     *         name:string,
     *         dependencies:list<class-string>,
     *         resources:list<array<string,mixed>>
     *     }>
     * }
     */
    public function toPayload(): array
    {
        return [
            'version' => 1,
            'modules' => array_map(
                static fn(CompiledModule $module) => $module->toPayload(),
                $this->modules,
            ),
        ];
    }

    /**
     * @param array{
     *     version:int,
     *     modules:list<array{
     *         class:class-string,
     *         name:string,
     *         dependencies:list<class-string>,
     *         resources:list<array<string,mixed>>
     *     }>
     * } $payload
     */
    public static function fromPayload(
        array $payload,
    ): self {

        if (($payload['version'] ?? 0) !== 1) {

            throw new \InvalidArgumentException(
                'Unsupported compiled module manifest version.'
            );
        }

        $modules = $payload['modules'] ?? [];

        return new self(
            array_map(
                static fn(array $module) => CompiledModule::fromPayload($module),
                $modules,
            ),
        );
    }
}
