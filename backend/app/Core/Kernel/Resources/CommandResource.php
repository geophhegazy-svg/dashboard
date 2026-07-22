<?php

declare(strict_types=1);

namespace App\Core\Kernel\Resources;

use App\Core\Kernel\Contracts\ModuleResourceInterface;

final readonly class CommandResource implements ModuleResourceInterface
{
    /**
     * @param array<class-string> $commands
     */
    public function __construct(
        private array $commands,
    ) {}

    /**
     * @return array<class-string>
     */
    public function commands(): array
    {
        return $this->commands;
    }

    public function register(): void
    {
        // سيتtegration.م تنفيذ التسجيل الفعلي داخل Infrastructure
        // في Sprint Console In
    }
}
