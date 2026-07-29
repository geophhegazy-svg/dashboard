<?php

declare(strict_types=1);

namespace App\Core\Kernel\Bootstrap;

use App\Core\Kernel\Contracts\KernelBootstrapperInterface;
use App\Core\Kernel\Contracts\KernelValidatorInterface;
use App\Core\Kernel\Contracts\ModuleLoaderInterface;
use App\Core\Kernel\Compiler\CompiledManifestProvider;
use App\Core\Kernel\Context\KernelContext;
use App\Core\Kernel\Events\KernelBooted;
use App\Core\Kernel\Events\KernelBooting;
use App\Core\Kernel\Monitoring\KernelBootStage;
use App\Core\Kernel\Monitoring\KernelBootTimeline;
use App\Core\Kernel\Registration\CompiledManifestRegistrationService;
use App\Core\Kernel\Contracts\ModuleRegistrarInterface;
use App\Core\Kernel\Runtime\KernelRuntimeContext;
use App\Core\Kernel\Runtime\KernelRuntimeState;
use RuntimeException;
use Throwable;
use App\Core\Kernel\Lifecycle\KernelLifecycleManager;
use App\Core\Kernel\Lifecycle\KernelLifecycleState;
use App\Core\Kernel\Lifecycle\Events\KernelStarting;
use App\Core\Kernel\Lifecycle\Events\KernelStarted;
use App\Core\Kernel\Lifecycle\Events\KernelFailed;
use App\Core\EventBus\Contracts\EventDispatcherInterface;
use App\Core\Kernel\Lifecycle\Registration\LifecycleEventRegistrar;

/**
 * @internal
 */
final readonly class KernelBootstrapper
implements KernelBootstrapperInterface
{
    public function __construct(
        private ModuleLoaderInterface $loader,
        private KernelValidatorInterface $validator,
        private CompiledManifestProvider $manifestProvider,
        private CompiledManifestRegistrationService $registration,
        private ModuleRegistrarInterface $registrar,
        private KernelRuntimeState $runtime,
        private KernelLifecycleManager $lifecycle,
        private KernelBootTimeline $timeline,
        private EventDispatcherInterface $events,
        private LifecycleEventRegistrar $lifecycleEvents,
    ) {}


    public function boot(): void
    {
        try {

            $this->timeline->start();

            $this->lifecycle->transition(
                KernelLifecycleState::Starting,
            );

            $this->events->dispatch(
                new KernelStarting(
                    KernelLifecycleState::Starting,
                ),
            );


            $this->lifecycle->transition(
                KernelLifecycleState::Booting,
            );

            $this->events->dispatch(
                new KernelBooting(),
            );


            /*
        |--------------------------------------------------------------------------
        | Module Discovery
        |--------------------------------------------------------------------------
        */

            $start = microtime(true);

            $this->loader->reset();

            $registry = $this->loader->load();

            $this->timeline->record(
                KernelBootStage::Discovery,
                $start,
            );


            /*
        |--------------------------------------------------------------------------
        | Kernel Validation
        |--------------------------------------------------------------------------
        */

            $start = microtime(true);

            $result = $this->validator->validate(
                $registry,
            );

            $this->timeline->record(
                KernelBootStage::Validation,
                $start,
            );


            if (! $result->isValid()) {

                throw new RuntimeException(
                    "Kernel validation failed.\n\n"
                        . $result->exceptionMessage(),
                );
            }


            /*
        |--------------------------------------------------------------------------
        | Manifest Compilation
        |--------------------------------------------------------------------------
        */

            $start = microtime(true);

            $manifest = $this->manifestProvider->provide(
                $registry,
            );

            $this->timeline->record(
                KernelBootStage::Compilation,
                $start,
            );


            /*
        |--------------------------------------------------------------------------
        | Module Registration
        |--------------------------------------------------------------------------
        */

            $start = microtime(true);

            $this->lifecycleEvents->register();

            $this->registration->register(
                $manifest,
                $this->registrar,
            );

            $this->timeline->record(
                KernelBootStage::Registration,
                $start,
            );


            /*
        |--------------------------------------------------------------------------
        | Runtime Initialization
        |--------------------------------------------------------------------------
        */

            $start = microtime(true);

            $context = new KernelRuntimeContext(
                $manifest,
                new \DateTimeImmutable(),
            );


            $this->runtime->set(
                $context,
            );


            $this->lifecycle->transition(
                KernelLifecycleState::Ready,
            );


            $this->events->dispatch(
                new KernelStarted(
                    KernelLifecycleState::Ready,
                ),
            );


            $this->timeline->record(
                KernelBootStage::Runtime,
                $start,
            );


            $this->events->dispatch(
                new KernelBooted(
                    new KernelContext(
                        $context,
                    ),
                ),
            );

        } catch (Throwable $exception) {

            if (
                $this->lifecycle->state()
                !== KernelLifecycleState::Failed
            ) {

                $this->lifecycle->transition(
                    KernelLifecycleState::Failed,
                );
            }


            $this->events->dispatch(
                new KernelFailed(
                    $exception,
                ),
            );


            throw $exception;
        }
    }
}
