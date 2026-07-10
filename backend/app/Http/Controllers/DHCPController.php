<?php

namespace App\Http\Controllers;

use App\Services\Network\MikroTikAdvancedService;
use App\Models\NetworkDevice;
use Illuminate\Http\Request;

class DHCPController extends Controller
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

        $leases = [];
        $connected = false;

        if ($device) {
            $connected = $this->mikrotikService->connect(
                $device->ip_address,
                $device->username,
                $device->password,
                $device->port ?? 8728
            );

            if ($connected) {
                $allLeases = $this->mikrotikService->getDHCPLeases();
                $perPage = 50;
                $currentPage = $request->input('page', 1);
                $offset = ($currentPage - 1) * $perPage;
                $leases = array_slice($allLeases, $offset, $perPage);
                $total = count($allLeases);
                $lastPage = ceil($total / $perPage);
                
                // تخزين البيانات للـ Pagination
                $pagination = [
                    'current_page' => $currentPage,
                    'last_page' => $lastPage,
                    'per_page' => $perPage,
                    'total' => $total,
                    'from' => $offset + 1,
                    'to' => min($offset + $perPage, $total),
                ];
            }
        }

        return view('dhcp.index', compact('leases', 'devices', 'device', 'connected', 'pagination'));
    }

    public function create(Request $request)
    {
        $deviceId = $request->input('device_id', 1);
        $device = NetworkDevice::find($deviceId);
        $devices = NetworkDevice::where('status', 'active')->get();

        return view('dhcp.create', compact('devices', 'device'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'address' => 'required|string',
            'mac_address' => 'required|string',
            'hostname' => 'nullable|string',
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

        $result = $this->mikrotikService->addDHCPLease(
            $request->address,
            $request->mac_address,
            $request->hostname
        );

        if ($result) {
            return redirect()->route('dhcp.index', ['device_id' => $request->device_id])
                ->with('success', 'تم إضافة عقد الإيجار بنجاح');
        }

        return back()->with('error', 'فشل إضافة عقد الإيجار');
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

        $leases = $this->mikrotikService->getDHCPLeases();
        $lease = collect($leases)->firstWhere('id', $id);

        if (!$lease) {
            return redirect()->route('dhcp.index', ['device_id' => $deviceId])
                ->with('error', 'عقد الإيجار غير موجود');
        }

        return view('dhcp.edit', compact('lease', 'devices', 'device', 'id'));
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'address' => 'nullable|string',
            'mac_address' => 'nullable|string',
            'hostname' => 'nullable|string',
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

        $data = $request->only(['address', 'mac_address', 'hostname', 'comment']);
        $data = array_filter($data, function ($value) {
            return $value !== null && $value !== '';
        });

        $result = $this->mikrotikService->updateDHCPLease($id, $data);

        if ($result) {
            return redirect()->route('dhcp.index', ['device_id' => $request->device_id])
                ->with('success', 'تم تحديث عقد الإيجار بنجاح');
        }

        return back()->with('error', 'فشل تحديث عقد الإيجار');
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

        $result = $this->mikrotikService->deleteDHCPLease($id);

        if ($result) {
            return back()->with('success', 'تم حذف عقد الإيجار بنجاح');
        }

        return back()->with('error', 'فشل حذف عقد الإيجار');
    }
}
