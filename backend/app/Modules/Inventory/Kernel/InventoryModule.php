<?php

declare(strict_types=1);

namespace App\Modules\Inventory\Kernel;

use App\Core\Kernel\ModuleManifest;
use App\Core\Kernel\Modules\Module;

use App\Modules\Customer\Kernel\CustomerModule;

use App\Modules\Inventory\Domain\Contracts\DeviceRepositoryInterface;
use App\Modules\Inventory\Domain\Contracts\DeviceAssignmentRepositoryInterface;
use App\Modules\Inventory\Domain\Contracts\InventoryRepositoryInterface;

use App\Modules\Inventory\Infrastructure\Repositories\DeviceRepository;
use App\Modules\Inventory\Infrastructure\Repositories\DeviceAssignmentRepository;
use App\Modules\Inventory\Infrastructure\Repositories\InventoryRepository;

use App\Modules\Inventory\Infrastructure\Persistence\Models\Device;
use App\Modules\Inventory\Infrastructure\Persistence\Models\DeviceAssignment;
use App\Modules\Inventory\Infrastructure\Persistence\Models\Inventory;

use App\Modules\Inventory\Policies\DevicePolicy;
use App\Modules\Inventory\Policies\DeviceAssignmentPolicy;
use App\Modules\Inventory\Policies\InventoryPolicy;

use App\Modules\Inventory\Application\Actions\CreateInventoryAction;
use App\Modules\Inventory\Application\Actions\UpdateInventoryAction;
use App\Modules\Inventory\Application\Actions\DeleteInventoryAction;
use App\Modules\Inventory\Application\Actions\CreateDeviceAction;
use App\Modules\Inventory\Application\Actions\UpdateDeviceAction;
use App\Modules\Inventory\Application\Actions\DeleteDeviceAction;
use App\Modules\Inventory\Application\Actions\UpdateDeviceAssignmentAction;
use App\Modules\Inventory\Application\Actions\DeleteDeviceAssignmentAction;
use App\Modules\Inventory\Application\Actions\AssignDeviceAction;
use App\Modules\Inventory\Application\Actions\ReturnDeviceAction;

use App\Modules\Inventory\Application\Queries\PaginateInventoriesQuery;
use App\Modules\Inventory\Application\Queries\PaginateDevicesQuery;
use App\Modules\Inventory\Application\Queries\PaginateDeviceAssignmentsQuery;

use App\Modules\Inventory\Application\Queries\Handlers\PaginateInventoriesQueryHandler;
use App\Modules\Inventory\Application\Queries\Handlers\PaginateDevicesQueryHandler;
use App\Modules\Inventory\Application\Queries\Handlers\PaginateDeviceAssignmentsQueryHandler;

use App\Modules\Inventory\Application\Commands\CreateInventoryCommand;
use App\Modules\Inventory\Application\Commands\UpdateInventoryCommand;
use App\Modules\Inventory\Application\Commands\DeleteInventoryCommand;
use App\Modules\Inventory\Application\Commands\CreateDeviceCommand;
use App\Modules\Inventory\Application\Commands\UpdateDeviceCommand;
use App\Modules\Inventory\Application\Commands\DeleteDeviceCommand;
use App\Modules\Inventory\Application\Commands\UpdateDeviceAssignmentCommand;
use App\Modules\Inventory\Application\Commands\DeleteDeviceAssignmentCommand;
use App\Modules\Inventory\Application\Commands\AssignDeviceCommand;
use App\Modules\Inventory\Application\Commands\ReturnDeviceCommand;

use App\Modules\Inventory\Application\Commands\Handlers\CreateInventoryCommandHandler;
use App\Modules\Inventory\Application\Commands\Handlers\UpdateInventoryCommandHandler;
use App\Modules\Inventory\Application\Commands\Handlers\DeleteInventoryCommandHandler;
use App\Modules\Inventory\Application\Commands\Handlers\CreateDeviceCommandHandler;
use App\Modules\Inventory\Application\Commands\Handlers\UpdateDeviceCommandHandler;
use App\Modules\Inventory\Application\Commands\Handlers\DeleteDeviceCommandHandler;
use App\Modules\Inventory\Application\Commands\Handlers\UpdateDeviceAssignmentCommandHandler;
use App\Modules\Inventory\Application\Commands\Handlers\DeleteDeviceAssignmentCommandHandler;
use App\Modules\Inventory\Application\Commands\Handlers\AssignDeviceCommandHandler;
use App\Modules\Inventory\Application\Commands\Handlers\ReturnDeviceCommandHandler;

final class InventoryModule extends Module
{
    public function name(): string
    {
        return 'Inventory';
    }

    public function dependencies(): array
    {
        return [
            CustomerModule::class,
        ];
    }

    public function manifest(): ModuleManifest
    {
        return ModuleManifest::make()

            ->services([

                DeviceRepositoryInterface::class
                    => DeviceRepository::class,

                DeviceAssignmentRepositoryInterface::class
                    => DeviceAssignmentRepository::class,

                InventoryRepositoryInterface::class
                    => InventoryRepository::class,

            ])

            ->actions([

                CreateInventoryAction::class,
                UpdateInventoryAction::class,
                DeleteInventoryAction::class,

                CreateDeviceAction::class,
                UpdateDeviceAction::class,
                DeleteDeviceAction::class,

                UpdateDeviceAssignmentAction::class,
                DeleteDeviceAssignmentAction::class,

                AssignDeviceAction::class,
                ReturnDeviceAction::class,

            ])

            ->queries([

                PaginateInventoriesQuery::class
                    => PaginateInventoriesQueryHandler::class,

                PaginateDevicesQuery::class
                    => PaginateDevicesQueryHandler::class,

                PaginateDeviceAssignmentsQuery::class
                    => PaginateDeviceAssignmentsQueryHandler::class,

            ])

            ->commandHandlers([

                CreateInventoryCommand::class
                    => CreateInventoryCommandHandler::class,

                UpdateInventoryCommand::class
                    => UpdateInventoryCommandHandler::class,

                DeleteInventoryCommand::class
                    => DeleteInventoryCommandHandler::class,

                CreateDeviceCommand::class
                    => CreateDeviceCommandHandler::class,

                UpdateDeviceCommand::class
                    => UpdateDeviceCommandHandler::class,

                DeleteDeviceCommand::class
                    => DeleteDeviceCommandHandler::class,

                UpdateDeviceAssignmentCommand::class
                    => UpdateDeviceAssignmentCommandHandler::class,

                DeleteDeviceAssignmentCommand::class
                    => DeleteDeviceAssignmentCommandHandler::class,

                AssignDeviceCommand::class
                    => AssignDeviceCommandHandler::class,

                ReturnDeviceCommand::class
                    => ReturnDeviceCommandHandler::class,

            ])

            ->policies([

                Device::class
                    => DevicePolicy::class,

                DeviceAssignment::class
                    => DeviceAssignmentPolicy::class,

                Inventory::class
                    => InventoryPolicy::class,

            ]);
    }
}
