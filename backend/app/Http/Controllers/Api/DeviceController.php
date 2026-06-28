<?php

namespace App\Http\Controllers\Api;

use App\Models\Device;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreDeviceRequest;
use App\Http\Resources\DeviceResource;

class DeviceController extends Controller
{
    public function index()
    {
        return DeviceResource::collection(Device::latest()->paginate());
    }
    public function store(StoreDeviceRequest $request)
    {
        $device = Device::create($request->validated());
        return response()->json(['data' => new DeviceResource($device)]);
    }
    public function show(Device $device)
    {
        return new DeviceResource($device);
    }
    public function update(StoreDeviceRequest $request, Device $device)
    {
        $device->update($request->validated());
        return new DeviceResource($device);
    }
    public function destroy(Device $device)
    {
        $device->delete();
        return response()->json(['message' => 'Device deleted successfully']);
    }
}
