<?php

declare(strict_types=1);

namespace Tests\Feature\Core\Kernel;

use App\Core\Kernel\Bootstrap\KernelBootstrapper;
use App\Core\Kernel\Contracts\KernelBootstrapperInterface;
use App\Core\Kernel\Contracts\ModuleRegistrarInterface;
use App\Infrastructure\Laravel\Kernel\LaravelModuleRegistrar;
use App\Infrastructure\Laravel\Providers\EgyptNetKernelServiceProvider;
use Illuminate\Support\ServiceProvider;
use Tests\TestCase;

final class KernelRegistrationAuthorityTest extends TestCase
{
    public function test_egyptnet_kernel_provider_is_registered(): void
    {
        $providers = $this->app->getLoadedProviders();

        self::assertArrayHasKey(
            EgyptNetKernelServiceProvider::class,
            $providers,
        );
    }

    public function test_kernel_bootstrapper_contract_has_single_authority(): void
    {
        $resolved = $this->app->make(
            KernelBootstrapperInterface::class,
        );

        self::assertInstanceOf(
            KernelBootstrapper::class,
            $resolved,
        );

        self::assertSame(
            $resolved,
            $this->app->make(
                KernelBootstrapperInterface::class,
            ),
        );
    }

    public function test_module_registrar_contract_resolves_to_laravel_boundary(): void
    {
        $resolved = $this->app->make(
            ModuleRegistrarInterface::class,
        );

        self::assertInstanceOf(
            LaravelModuleRegistrar::class,
            $resolved,
        );
    }

    public function test_kernel_bootstrapper_is_the_bootstrap_invocation_boundary(): void
    {
        $reflection = new \ReflectionClass(
            EgyptNetKernelServiceProvider::class,
        );

        $boot = $reflection->getMethod('boot');

        $source = file_get_contents(
            $reflection->getFileName(),
        );

        self::assertNotFalse($source);

        self::assertStringContainsString(
            'KernelBootstrapperInterface::class',
            $source,
        );

        self::assertStringContainsString(
            '->boot();',
            $source,
        );

        self::assertSame(
            1,
            substr_count(
                $source,
                '->make(KernelBootstrapperInterface::class)',
            ),
        );
    }

    public function test_module_registration_has_single_compiled_authority(): void
    {
        $source = file_get_contents(
            base_path(
                'app/Core/Kernel/Bootstrap/KernelBootstrapper.php',
            ),
        );

        self::assertNotFalse($source);

        self::assertStringContainsString(
            'CompiledManifestRegistrationService',
            $source,
        );

        self::assertStringContainsString(
            '$this->registration->register(',
            $source,
        );

        self::assertSame(
            1,
            substr_count(
                $source,
                '$this->registration->register(',
            ),
        );
    }
}
