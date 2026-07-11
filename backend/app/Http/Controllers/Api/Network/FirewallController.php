<?php

namespace App\Http\Controllers\Api\Network;

use App\Services\Network\MikroTikAdvancedService;
use App\Models\NetworkDevice;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FirewallController extends Controller
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

        $rules = [];
        $connected = false;

        if ($device) {
            $connected = $this->mikrotikService->connect(
                $device->ip_address,
                $device->username,
                $device->password,
                $device->port ?? 8728
            );

            if ($connected) {
                $rules = $this->mikrotikService->getFirewallRules();
            }
        }

        return view('firewall.index', compact('rules', 'devices', 'device', 'connected'));
    }

    public function create(Request $request)
    {
        $deviceId = $request->input('device_id', 1);
        $device = NetworkDevice::find($deviceId);
        $devices = NetworkDevice::where('status', 'active')->get();

        return view('firewall.create', compact('devices', 'device'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'chain' => 'required|string|in:input,output,forward,hs-input,hs-unauth,hs-unauth-to',
            'action' => 'required|string|in:accept,drop,reject,log,jump,passthrough',
            'src_address' => 'nullable|string',
            'dst_address' => 'nullable|string',
            'protocol' => 'nullable|string',
            'dst_port' => 'nullable|string',
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

        $result = $this->mikrotikService->createFirewallRule($request->all());

        if ($result) {
            return redirect()->route('firewall.index', ['device_id' => $request->device_id])
                ->with('success', 'تم إنشاء القاعدة بنجاح');
        }

        return back()->with('error', 'فشل إنشاء القاعدة');
    }

    public function edit(Request $request, string $id)
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

        $rules = $this->mikrotikService->getFirewallRules();
        $rule = collect($rules)->firstWhere('id', $id);

        if (!$rule) {
            return redirect()->route('firewall.index', ['device_id' => $deviceId])
                ->with('error', 'القاعدة غير موجودة');
        }

        return view('firewall.edit', compact('rule', 'devices', 'device', 'id'));
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'chain' => 'nullable|string|in:input,output,forward,hs-input,hs-unauth,hs-unauth-to',
            'action' => 'nullable|string|in:accept,drop,reject,log,jump,passthrough',
            'src_address' => 'nullable|string',
            'dst_address' => 'nullable|string',
            'protocol' => 'nullable|string',
            'dst_port' => 'nullable|string',
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

        $data = $request->only(['chain', 'action', 'src_address', 'dst_address', 'protocol', 'dst_port', 'comment']);
        $data = array_filter($data, function ($value) {
            return $value !== null && $value !== '';
        });

        $result = $this->mikrotikService->updateFirewallRule($id, $data);

        if ($result) {
            return redirect()->route('firewall.index', ['device_id' => $request->device_id])
                ->with('success', 'تم تحديث القاعدة بنجاح');
        }

        return back()->with('error', 'فشل تحديث القاعدة');
    }

    public function destroy(Request $request, string $id)
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

        $result = $this->mikrotikService->deleteFirewallRule($id);

        if ($result) {
            return back()->with('success', 'تم حذف القاعدة بنجاح');
        }

        return back()->with('error', 'فشل حذف القاعدة');
    }
}
