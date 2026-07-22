<?php

declare(strict_types=1);

namespace App\Core\Kernel\Resources;

use App\Core\Kernel\Contracts\ModuleRegistrarInterface;
use App\Core\Kernel\Contracts\ModuleResourceInterface;

final readonly class PolicyResource implements ModuleResourceInterface
{
    /**
     * @param array<class-string,class-string> $policies
     */
    public function __construct(
        private array $policies,
    ) {}

    public function register(
        ModuleRegistrarInterface $registrar
    ): void {

        foreach ($this->policies as $model => $policy) {

            $registrar->registerPolicy(
                $model,
                $policy,
            );
        }
    }
}
