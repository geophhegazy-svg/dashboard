<?php

declare(strict_types=1);

namespace App\Core\Kernel;

use App\Core\Kernel\Contracts\ModuleResourceInterface;
use App\Core\Kernel\Resources\ActionResource;
use App\Core\Kernel\Resources\CommandResource;
use App\Core\Kernel\Resources\ListenerResource;
use App\Core\Kernel\Resources\PolicyResource;
use App\Core\Kernel\Resources\QueryResource;
use App\Core\Kernel\Resources\ScheduleResource;
use App\Core\Kernel\Resources\ServiceResource;

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

    /**
     * @param array<class-string,class-string> $bindings
     */
    public function services(
        array $bindings,
    ): self {

        return $this->add(
            new ServiceResource(
                $bindings,
            ),
        );
    }

    /**
     * @param array<int,class-string> $actions
     */
    public function actions(
        array $actions,
    ): self {

        return $this->add(
            new ActionResource(
                $actions,
            ),
        );
    }

    /**
     * @param array<class-string,class-string> $queries
     */
    public function queries(
        array $queries,
    ): self {

        return $this->add(
            new QueryResource(
                $queries,
            ),
        );
    }

    /**
     * @param array<class-string,array<class-string>> $listeners
     */
    public function listeners(
        array $listeners,
    ): self {

        return $this->add(
            new ListenerResource(
                $listeners,
            ),
        );
    }

    /**
     * @param array<int,class-string> $commands
     */
    public function commands(
        array $commands,
    ): self {

        return $this->add(
            new CommandResource(
                $commands,
            ),
        );
    }

    public function resources(): ModuleResourceCollection
    {
        return $this->resources;
    }
}
