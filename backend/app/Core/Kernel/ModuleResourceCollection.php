<?php

declare(strict_types=1);

namespace App\Core\Kernel;

use ArrayIterator;
use Countable;
use IteratorAggregate;
use Traversable;
use App\Core\Kernel\Contracts\ModuleResourceInterface;

final class ModuleResourceCollection
implements IteratorAggregate, Countable
{
    /**
     * @var list<ModuleResourceInterface>
     */
    private array $resources = [];

    /**
     * @param list<ModuleResourceInterface> $resources
     */
    public function __construct(
        array $resources = [],
    ) {
        $this->resources = $resources;
    }

    public function add(
        ModuleResourceInterface $resource,
    ): self {

        $clone = clone $this;

        $clone->resources[] = $resource;

        return $clone;
    }

    /**
     * @return Traversable<int, ModuleResourceInterface>
     */
    public function getIterator(): Traversable
    {
        return new ArrayIterator(
            $this->resources,
        );
    }

    /**
     * @return list<ModuleResourceInterface>
     */
    public function all(): array
    {
        return $this->resources;
    }

    public function count(): int
    {
        return count(
            $this->resources,
        );
    }

    public function isEmpty(): bool
    {
        return $this->resources === [];
    }

    public function isNotEmpty(): bool
    {
        return $this->resources !== [];
    }

    public function first(): ?ModuleResourceInterface
    {
        return $this->resources[0] ?? null;
    }
}
