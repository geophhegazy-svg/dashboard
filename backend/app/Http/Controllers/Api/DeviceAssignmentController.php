<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Core\CommandBus\CommandDispatcher;
use App\Core\QueryBus\QueryDispatcher;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreDeviceAssignmentRequest;
use App\Http\Resources\DeviceAssignmentResource;
use App\Modules\Inventory\Application\Commands\AssignDeviceCommand;
use App\Modules\Inventory\Application\Commands\DeleteDeviceAssignmentCommand;
use App\Modules\Inventory\Application\Commands\ReturnDeviceCommand;
use App\Modules\Inventory\Application\Commands\UpdateDeviceAssignmentCommand;
use App\Modules\Inventory\Application\Queries\PaginateDeviceAssignmentsQuery;
use App\Modules\Inventory\Infrastructure\Persistence\Models\DeviceAssignment;

final class DeviceAssignmentController extends Controller
{
    public function __construct(
        private readonly CommandDispatcher $commandDispatcher,
        private readonly QueryDispatcher $queryDispatcher,
    ) {}

    public function index()
    {
        $this->authorize(
            'viewAny',
            DeviceAssignment::class
        );

        return DeviceAssignmentResource::collection(
            $this->queryDispatcher->dispatch(
                new PaginateDeviceAssignmentsQuery()
            )
        );
    }

    public function store(StoreDeviceAssignmentRequest $request)
    {
        $this->authorize(
            'create',
            DeviceAssignment::class
        );

        $assignment = $this->commandDispatcher->dispatch(
            new AssignDeviceCommand(
                $request->validated()
            )
        );

        return new DeviceAssignmentResource($assignment);
    }

    public function show(
        DeviceAssignment $deviceAssignment
    ): DeviceAssignmentResource {
        $this->authorize(
            'view',
            $deviceAssignment
        );

        return new DeviceAssignmentResource(
            $deviceAssignment
        );
    }

    public function update(
        StoreDeviceAssignmentRequest $request,
        DeviceAssignment $deviceAssignment
    ) {
        $this->authorize(
            'update',
            $deviceAssignment
        );

        $assignment = $this->commandDispatcher->dispatch(
            new UpdateDeviceAssignmentCommand(
                $deviceAssignment,
                $request->validated(),
            )
        );

        return new DeviceAssignmentResource(
            $assignment
        );
    }

    public function destroy(
        DeviceAssignment $deviceAssignment
    ) {
        $this->authorize(
            'delete',
            $deviceAssignment
        );

        $this->commandDispatcher->dispatch(
            new DeleteDeviceAssignmentCommand(
                $deviceAssignment,
            )
        );

        return response()->json([
            'message' => 'Assignment deleted successfully',
        ]);
    }

    public function returnDevice(
        DeviceAssignment $deviceAssignment
    ) {
        $this->authorize(
            'update',
            $deviceAssignment
        );

        $this->commandDispatcher->dispatch(
            new ReturnDeviceCommand(
                $deviceAssignment,
            )
        );

        return response()->json([
            'message' => 'Device returned successfully',
        ]);
    }
}
