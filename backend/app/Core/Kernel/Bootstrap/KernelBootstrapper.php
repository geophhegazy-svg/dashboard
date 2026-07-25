<?php

declare(strict_types=1);

namespace App\Core\Kernel\Bootstrap;

use App\Core\Kernel\Contracts\KernelBootstrapperInterface;
use App\Core\Kernel\Contracts\KernelValidatorInterface;
use App\Core\Kernel\Contracts\ModuleLoaderInterface;
use App\Core\Kernel\Events\KernelBooted;
use App\Core\Kernel\Events\KernelBooting;
use App\Core\Kernel\Registration\ModuleRegistrationService;
use RuntimeException;

final readonly class KernelBootstrapper
implements KernelBootstrapperInterface
{
    public function __construct(
        private ModuleLoaderInterface $loader,
        private KernelValidatorInterface $validator,
        private ModuleRegistrationService $registration,
    ) {}

    public function boot(): void
    {
        event(
            new KernelBooting(),
        );

        $registry = $this->loader->load();

        $result = $this->validator->validate(
            $registry,
        );

        if (! $result->isValid()) {

            throw new RuntimeException(
                "Kernel validation failed.\n\n"
                    . $result->exceptionMessage(),
            );
        }

        $this->registration->register(
            $registry,
        );

        event(
            new KernelBooted(),
        );
    }
}
