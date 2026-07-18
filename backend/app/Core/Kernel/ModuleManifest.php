<?php

declare(strict_types=1);

namespace App\Core\Kernel;

use App\Core\Kernel\Contracts\ModuleResourceInterface;

final class ModuleManifest
{
    private ModuleResourceCollection $resources;

    private function __construct()
    {
        $this->resources = new ModuleResourceCollection();
    }

    public static function make(): self
    {
        return new self();
    }

    public function add(
        ModuleResourceInterface $resource,
    ): self {

        $clone = clone $this;

        $clone->resources = $clone->resources->add(
            $resource,
        );

        return $clone;
    }

    public function resources(): ModuleResourceCollection
    {
        return $this->resources;
    }
}
