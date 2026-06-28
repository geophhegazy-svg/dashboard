<?php

namespace App\Http\Controllers\Api;

use App\Models\Device;
use App\Models\Inventory;
use App\Models\DeviceAssignment;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreDeviceAssignmentRequest;
use App\Http\Resources\DeviceAssignmentResource;

class DeviceAssignmentController extends Controller
{
    public function index()
    {
        return DeviceAssignmentResource::collection(DeviceAssignment::latest()->paginate());
    }
    public function store(StoreDeviceAssignmentRequest $request)
    {
        $data = $request->validated();
        $device = Device::findOrFail($data['device_id']);
        $inventory = Inventory::where('tenant_id', $data['tenant_id'])->where('device_type', $device->device_type)->where('brand', $device->brand)->where('model', $device->model)->first();
        if ($inventory && $inventory->quantity > 0) {
            $inventory->decrement('quantity');
        }
        $assignment = DeviceAssignment::create($data);
        return response()->json(['data' => new DeviceAssignmentResource($assignment)]);
    }
    public function returnDevice(
        DeviceAssignment $deviceAssignment
    ) {
        if ($deviceAssignment->status === 'returned') {

            return response()->json([
                'message' => 'Device already returned'
            ], 422);
        }

        $deviceAssignment->update([
            'status'      => 'returned',
            'returned_at' => now(),
        ]);

        $inventory = Inventory::where(
            'tenant_id',
            $deviceAssignment->tenant_id
        )
            ->where(
                'device_type',
                $deviceAssignment->device->device_type
            )
            ->where(
                'brand',
                $deviceAssignment->device->brand
            )
            ->where(
                'model',
                $deviceAssignment->device->model
            )
            ->first();

        if ($inventory) {
            $inventory->increment('quantity');
        }

        return response()->json([
            'message' => 'Device returned successfully'
        ]);
    }
    public function show(DeviceAssignment $deviceAssignment)
    {
        return new DeviceAssignmentResource($deviceAssignment);
    }
    public function update(StoreDeviceAssignmentRequest $request, DeviceAssignment $deviceAssignment)
    {
        $deviceAssignment->update($request->validated());
        return new DeviceAssignmentResource($deviceAssignment);
    }
    public function destroy(DeviceAssignment $deviceAssignment)
    {
        $deviceAssignment->delete();
        return response()->json(['message' => 'Assignment deleted successfully']);
    }
    
}
