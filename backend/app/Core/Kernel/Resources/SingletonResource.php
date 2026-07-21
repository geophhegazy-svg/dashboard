<?php

declare(strict_types=1);

namespace App\Core\Kernel\Resources;

use Illuminate\Contracts\Foundation\Application;
use App\Core\Kernel\Contracts\ModuleResourceInterface;

final readonly class SingletonResource implements ModuleResourceInterface
{
    /**
     * @param array<class-string,class-string> $bindings
     */
    public function __construct(
        private array $bindings = [],
    ) {}

    public function register(): void
    {
        /** @var Application $app */
        $app = app();

        foreach ($this->bindings as $abstract => $concrete) {
            $app->singleton(
                $abstract,
                $concrete,
            );
        }
    }
}
