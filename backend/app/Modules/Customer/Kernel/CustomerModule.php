<?php

declare(strict_types=1);

namespace App\Modules\Customer\Kernel;

use App\Core\Kernel\ModuleManifest;
use App\Core\Kernel\Modules\Module;
use App\Modules\Customer\Domain\Contracts\CustomerRepositoryInterface;
use App\Modules\Customer\Infrastructure\Repositories\CustomerRepository;
use App\Modules\Customer\Application\Actions\CreateCustomerAction;
use App\Modules\Customer\Application\Actions\UpdateCustomerAction;
use App\Modules\Customer\Application\Actions\ActivateCustomerAction;
use App\Modules\Customer\Application\Actions\DeactivateCustomerAction;
use App\Modules\Customer\Application\Actions\DeleteCustomerAction;
use App\Modules\Customer\Domain\Contracts\CustomerActivationServiceInterface;
use App\Modules\Customer\Domain\Services\CustomerActivationService;
use App\Modules\Customer\Application\Listeners\CustomerCreatedListener;
use App\Modules\Customer\Domain\Events\CustomerCreated;
use App\Modules\Customer\Application\Workflows\CreateCustomerWorkflow;
use App\Modules\Customer\Application\Commands\CreateCustomerCommand;
use App\Modules\Customer\Application\Commands\Handlers\CreateCustomerCommandHandler;

final class CustomerModule extends Module
{
    public function name(): string
    {
        return 'Customer';
    }

    public function dependencies(): array
    {
        return [];
    }

    public function manifest(): ModuleManifest
    {
        return ModuleManifest::make()

            ->services([

                CustomerRepositoryInterface::class
                => CustomerRepository::class,

                CustomerActivationServiceInterface::class
                => CustomerActivationService::class,

                CreateCustomerWorkflow::class
                => CreateCustomerWorkflow::class,

            ])

            ->actions([

                CreateCustomerAction::class,

                UpdateCustomerAction::class,

                ActivateCustomerAction::class,

                DeactivateCustomerAction::class,

                DeleteCustomerAction::class,

            ])

            ->listeners([

                CustomerCreated::class => [
                CustomerCreatedListener::class,
            ],

            ])

            ->commandHandlers([

                CreateCustomerCommand::class
                    => CreateCustomerCommandHandler::class,

            ]);
    }
}
