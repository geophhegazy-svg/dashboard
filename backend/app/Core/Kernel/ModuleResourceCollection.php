<?php

declare(strict_types=1);

namespace App\Core\Kernel;

use ArrayIterator;
use IteratorAggregate;
use Traversable;
use App\Core\Kernel\Contracts\ModuleResourceInterface;

final class ModuleResourceCollection implements IteratorAggregate
{
    /**
     * @var array<int, ModuleResourceInterface>
     */
    private array $resources = [];

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
     * @return array<int, ModuleResourceInterface>
     */
    public function all(): array
    {
        return $this->resources;
    }
}
