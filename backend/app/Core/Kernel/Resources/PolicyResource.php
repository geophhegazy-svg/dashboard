<?php

declare(strict_types=1);

namespace App\Core\Kernel\Resources;

use App\Core\Kernel\Contracts\ModuleResourceInterface;
use Illuminate\Support\Facades\Gate;

final readonly class PolicyResource implements ModuleResourceInterface
{
    /**
     * @param array<class-string,class-string> $policies
     */
    public function __construct(
        private array $policies,
    ) {}

    public function register(): void
    {
        foreach ($this->policies as $model => $policy) {
            Gate::policy($model, $policy);
        }
    }
}
