<?php

declare(strict_types=1);

namespace App\Infrastructure\Laravel\Container;

use App\Core\Contracts\ContainerInterface;
use Illuminate\Contracts\Container\Container;

final readonly class LaravelContainerAdapter
implements ContainerInterface
{
    public function __construct(
        private Container $container,
    ) {}


    public function make(
        string $abstract
    ): object {

        return $this->container->make(
            $abstract
        );
    }
}
