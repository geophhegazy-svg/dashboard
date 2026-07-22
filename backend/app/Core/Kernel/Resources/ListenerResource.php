<?php

declare(strict_types=1);

namespace App\Core\Kernel\Resources;

use App\Core\Kernel\Contracts\ModuleRegistrarInterface;
use App\Core\Kernel\Contracts\ModuleResourceInterface;

final readonly class ListenerResource implements ModuleResourceInterface
{
    /**
     * @param array<class-string,array<class-string>> $listeners
     */
    public function __construct(
        private array $listeners,
    ) {}

    public function register(
        ModuleRegistrarInterface $registrar
    ): void {

        foreach ($this->listeners as $event => $listeners) {

            foreach ($listeners as $listener) {

                $registrar->registerListener(
                    $event,
                    $listener,
                );
            }
        }
    }
}
