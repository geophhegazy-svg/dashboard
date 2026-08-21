<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Core\CommandBus\CommandDispatcher;
use App\Core\QueryBus\QueryDispatcher;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreDeviceRequest;
use App\Http\Resources\DeviceResource;
use App\Modules\Inventory\Application\Commands\CreateDeviceCommand;
use App\Modules\Inventory\Application\Commands\DeleteDeviceCommand;
use App\Modules\Inventory\Application\Commands\UpdateDeviceCommand;
use App\Modules\Inventory\Application\Queries\PaginateDevicesQuery;
use App\Modules\Inventory\Infrastructure\Persistence\Models\Device;

final class DeviceController extends Controller
{
    public function __construct(
        private readonly CommandDispatcher $commandDispatcher,
        private readonly QueryDispatcher $queryDispatcher,
    ) {}

    public function index()
    {
        $this->authorize('viewAny', Device::class);

        return DeviceResource::collection(
            $this->queryDispatcher->dispatch(
                new PaginateDevicesQuery()
            )
        );
    }

    public function store(StoreDeviceRequest $request)
    {
        $this->authorize('create', Device::class);

        $device = $this->commandDispatcher->dispatch(
            new CreateDeviceCommand(
                $request->validated()
            )
        );

        return new DeviceResource($device);
    }

    public function show(Device $device): DeviceResource
    {
        $this->authorize('view', $device);

        return new DeviceResource($device);
    }

    public function update(
        StoreDeviceRequest $request,
        Device $device
    ) {
        $this->authorize('update', $device);

        $device = $this->commandDispatcher->dispatch(
            new UpdateDeviceCommand(
                $device,
                $request->validated(),
            )
        );

        return new DeviceResource($device);
    }

    public function destroy(Device $device)
    {
        $this->authorize('delete', $device);

        $this->commandDispatcher->dispatch(
            new DeleteDeviceCommand(
                $device,
            )
        );

        return response()->json([
            'message' => 'Device deleted successfully',
        ]);
    }
}
