<?php

declare(strict_types=1);

namespace App\Core\Kernel;

use Illuminate\Contracts\Foundation\Application;
use App\Core\Kernel\Contracts\ModuleRegistrarInterface;

final readonly class ModuleRegistrar implements ModuleRegistrarInterface
{
    public function __construct(
        private Application $app,
    ) {}

    public function app(): Application
    {
        return $this->app;
    }

    public function bind(
        string $abstract,
        string $concrete,
    ): void {

        $this->app->bind(
            $abstract,
            $concrete,
        );
    }

    public function singleton(
        string $abstract,
        string $concrete,
    ): void {

        $this->app->singleton(
            $abstract,
            $concrete,
        );
    }
}
