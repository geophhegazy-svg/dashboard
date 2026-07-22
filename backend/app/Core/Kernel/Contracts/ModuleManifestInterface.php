<?php

declare(strict_types=1);

namespace App\Core\Kernel\Contracts;

interface ModuleManifestInterface
{
    public function name(): string;

    public function version(): string;

    public function providers(): array;

    public function resources(): array;

    public function metadata(): array;
}
