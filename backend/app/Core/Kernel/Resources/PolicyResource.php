<?php

declare(strict_types=1);

namespace App\Core\Kernel\Resources;

use App\Core\Kernel\Contracts\ModuleRegistrarInterface;
use App\Core\Kernel\Contracts\CompilableModuleResourceInterface;

final readonly class PolicyResource implements CompilableModuleResourceInterface
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

    public function compile(): array
    {
        return [
            'type' => 'policies',
            'policies' => $this->policies,
        ];
    }
}
