<?php

declare(strict_types=1);

namespace Tests\Fakes\Kernel;

use App\Core\Kernel\ModuleManifest;
use App\Core\Kernel\Modules\Module;

class FakeModule extends Module
{
    /**
     * @param array<class-string> $dependencies
     */
    public function __construct(
        private readonly string $moduleName,
        private readonly array $dependencies = [],
    ) {}

    public function name(): string
    {
        return $this->moduleName;
    }

    public function dependencies(): array
    {
        return $this->dependencies;
    }

    public function manifest(): ModuleManifest
    {
        return ModuleManifest::make();
    }
}
