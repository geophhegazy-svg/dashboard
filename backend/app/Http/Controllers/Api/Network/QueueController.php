<?php

namespace App\Http\Controllers\Api\Network;

use App\Services\Network\MikroTikAdvancedService;
use App\Models\NetworkDevice;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class QueueController extends Controller
{
    protected $mikrotikService;

    public function __construct(MikroTikAdvancedService $mikrotikService)
    {
        $this->mikrotikService = $mikrotikService;
    }

    public function index(Request $request)
    {
        $deviceId = $request->input('device_id', 1);
        $device = NetworkDevice::find($deviceId);
        $devices = NetworkDevice::where('status', 'active')->get();

        $queues = [];
        $connected = false;

        if ($device) {
            $connected = $this->mikrotikService->connect(
                $device->ip_address,
                $device->username,
                $device->password,
                $device->port ?? 8728
            );

            if ($connected) {
                $queues = $this->mikrotikService->getSimpleQueues();
            }
        }

        return view('queues.index', compact('queues', 'devices', 'device', 'connected'));
    }

    public function create(Request $request)
    {
        $deviceId = $request->input('device_id', 1);
        $device = NetworkDevice::find($deviceId);
        $devices = NetworkDevice::where('status', 'active')->get();

        return view('queues.create', compact('devices', 'device'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'target' => 'required|string',
            'max_limit' => 'required|string',
            'limit_at' => 'nullable|string',
            'priority' => 'nullable|integer|min:1|max:8',
            'device_id' => 'required|integer|exists:network_devices,id',
        ]);

        $device = NetworkDevice::find($request->device_id);

        $connected = $this->mikrotikService->connect(
            $device->ip_address,
            $device->username,
            $device->password,
            $device->port ?? 8728
        );

        if (!$connected) {
            return back()->with('error', 'فشل الاتصال بالجهاز');
        }

        $result = $this->mikrotikService->createSimpleQueue(
            $request->name,
            $request->target,
            $request->max_limit,
            $request->limit_at,
            $request->priority ?? 1
        );

        if ($result) {
            return redirect()->route('queues.index', ['device_id' => $request->device_id])
                ->with('success', 'تم إنشاء الـ Queue بنجاح');
        }

        return back()->with('error', 'فشل إنشاء الـ Queue');
    }

    public function edit(Request $request, string $name)
    {
        $deviceId = $request->input('device_id', 1);
        $device = NetworkDevice::find($deviceId);
        $devices = NetworkDevice::where('status', 'active')->get();

        $connected = $this->mikrotikService->connect(
            $device->ip_address,
            $device->username,
            $device->password,
            $device->port ?? 8728
        );

        if (!$connected) {
            return back()->with('error', 'فشل الاتصال بالجهاز');
        }

        $queues = $this->mikrotikService->getSimpleQueues();
        $queue = collect($queues)->firstWhere('name', $name);

        if (!$queue) {
            return redirect()->route('queues.index', ['device_id' => $deviceId])
                ->with('error', 'الـ Queue غير موجودة');
        }

        return view('queues.edit', compact('queue', 'devices', 'device', 'name'));
    }

    public function update(Request $request, string $name)
    {
        $request->validate([
            'max_limit' => 'nullable|string',
            'limit_at' => 'nullable|string',
            'priority' => 'nullable|integer|min:1|max:8',
            'comment' => 'nullable|string',
            'device_id' => 'required|integer|exists:network_devices,id',
        ]);

        $device = NetworkDevice::find($request->device_id);

        $connected = $this->mikrotikService->connect(
            $device->ip_address,
            $device->username,
            $device->password,
            $device->port ?? 8728
        );

        if (!$connected) {
            return back()->with('error', 'فشل الاتصال بالجهاز');
        }

        $result = $this->mikrotikService->updateSimpleQueue($name, $request->only([
            'max_limit', 'limit_at', 'priority', 'comment'
        ]));

        if ($result) {
            return redirect()->route('queues.index', ['device_id' => $request->device_id])
                ->with('success', 'تم تحديث الـ Queue بنجاح');
        }

        return back()->with('error', 'فشل تحديث الـ Queue');
    }

    public function toggle(Request $request, string $name)
    {
        $deviceId = $request->input('device_id', 1);
        $action = $request->input('action', 'disable');

        $device = NetworkDevice::find($deviceId);

        $connected = $this->mikrotikService->connect(
            $device->ip_address,
            $device->username,
            $device->password,
            $device->port ?? 8728
        );

        if (!$connected) {
            return back()->with('error', 'فشل الاتصال بالجهاز');
        }

        $result = $action === 'enable'
            ? $this->mikrotikService->enableSimpleQueue($name)
            : $this->mikrotikService->disableSimpleQueue($name);

        if ($result) {
            return back()->with('success', "تم {$action} الـ Queue بنجاح");
        }

        return back()->with('error', "فشل {$action} الـ Queue");
    }

    public function destroy(Request $request, string $name)
    {
        $deviceId = $request->input('device_id', 1);

        $device = NetworkDevice::find($deviceId);

        $connected = $this->mikrotikService->connect(
            $device->ip_address,
            $device->username,
            $device->password,
            $device->port ?? 8728
        );

        if (!$connected) {
            return back()->with('error', 'فشل الاتصال بالجهاز');
        }

        $result = $this->mikrotikService->deleteSimpleQueue($name);

        if ($result) {
            return back()->with('success', 'تم حذف الـ Queue بنجاح');
        }

        return back()->with('error', 'فشل حذف الـ Queue');
    }
}
