<?php

declare(strict_types=1);

namespace App\Infrastructure\Laravel\Providers;

use Illuminate\Support\ServiceProvider;

use App\Core\Contracts\ContainerInterface;

use App\Core\Kernel\Contracts\KernelValidatorInterface;

use App\Core\Kernel\Validation\KernelValidator;
use App\Core\Kernel\Validation\KernelValidationRuleRegistry;

use App\Core\Kernel\Validation\DuplicateResourceDetector;

use App\Core\Kernel\Validation\Extractors\ActionExtractor;
use App\Core\Kernel\Validation\Extractors\CommandExtractor;
use App\Core\Kernel\Validation\Extractors\QueryExtractor;
use App\Core\Kernel\Validation\Extractors\ServiceExtractor;

use App\Core\Kernel\Validation\Rules\CircularDependencyRule;
use App\Core\Kernel\Validation\Rules\DuplicateActionRule;
use App\Core\Kernel\Validation\Rules\DuplicateCommandRule;
use App\Core\Kernel\Validation\Rules\DuplicateModuleClassRule;
use App\Core\Kernel\Validation\Rules\DuplicateModuleNameRule;
use App\Core\Kernel\Validation\Rules\DuplicateQueryRule;
use App\Core\Kernel\Validation\Rules\DuplicateServiceRule;
use App\Core\Kernel\Validation\Rules\MissingDependencyRule;

final class KernelValidationServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        /*
        |--------------------------------------------------------------------------
        | Validation Infrastructure
        |--------------------------------------------------------------------------
        */

        $this->app->singleton(
            DuplicateResourceDetector::class,
        );

        $this->app->singleton(
            ServiceExtractor::class,
        );

        $this->app->singleton(
            ActionExtractor::class,
        );

        $this->app->singleton(
            QueryExtractor::class,
        );

        $this->app->singleton(
            CommandExtractor::class,
        );

        /*
        |--------------------------------------------------------------------------
        | Validation Rules
        |--------------------------------------------------------------------------
        */

        $this->app->singleton(
            CircularDependencyRule::class,
        );

        $this->app->singleton(
            DuplicateModuleClassRule::class,
        );

        $this->app->singleton(
            DuplicateModuleNameRule::class,
        );

        $this->app->singleton(
            MissingDependencyRule::class,
        );

        $this->app->singleton(
            DuplicateServiceRule::class,
        );

        $this->app->singleton(
            DuplicateActionRule::class,
        );

        $this->app->singleton(
            DuplicateQueryRule::class,
        );

        $this->app->singleton(
            DuplicateCommandRule::class,
        );

        /*
        |--------------------------------------------------------------------------
        | Registry
        |--------------------------------------------------------------------------
        */

        $this->app->singleton(
            KernelValidationRuleRegistry::class,
            fn($app) => new KernelValidationRuleRegistry(
                $app->make(ContainerInterface::class),
                [
                    CircularDependencyRule::class,
                    DuplicateModuleClassRule::class,
                    DuplicateModuleNameRule::class,
                    MissingDependencyRule::class,
                    DuplicateServiceRule::class,
                    DuplicateActionRule::class,
                    DuplicateQueryRule::class,
                    DuplicateCommandRule::class,
                ],
            ),
        );

        /*
        |--------------------------------------------------------------------------
        | Validator
        |--------------------------------------------------------------------------
        */

        $this->app->singleton(
            KernelValidatorInterface::class,
            fn($app) => new KernelValidator(
                $app->make(KernelValidationRuleRegistry::class),
            ),
        );
    }
}
