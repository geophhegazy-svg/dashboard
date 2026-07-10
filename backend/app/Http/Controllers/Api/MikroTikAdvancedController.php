<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\Network\MikroTikAdvancedService;
use App\Models\NetworkDevice;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class MikroTikAdvancedController extends Controller
{
    protected $mikrotikService;

    public function __construct(MikroTikAdvancedService $mikrotikService)
    {
        $this->mikrotikService = $mikrotikService;
    }

    /**
     * الاتصال بجهاز MikroTik
     */
    protected function connectToDevice(int $deviceId): bool
    {
        $device = NetworkDevice::find($deviceId);
        if (!$device) {
            return false;
        }

        return $this->mikrotikService->connect(
            $device->ip_address,
            $device->username,
            $device->password,
            $device->port ?? 8728
        );
    }

    // ========== إدارة الـ Queues ==========

    public function getQueues(Request $request): JsonResponse
    {
        $deviceId = $request->input('device_id', 1);

        if (!$this->connectToDevice($deviceId)) {
            return response()->json([
                'success' => false,
                'message' => 'فشل الاتصال بالجهاز',
            ], 500);
        }

        $queues = $this->mikrotikService->getSimpleQueues();

        return response()->json([
            'success' => true,
            'data' => $queues,
            'count' => count($queues),
        ]);
    }

    public function createQueue(Request $request): JsonResponse
    {
        $request->validate([
            'name' => 'required|string',
            'target' => 'required|string',
            'max_limit' => 'required|string',
            'limit_at' => 'nullable|string',
            'priority' => 'nullable|integer|min:1|max:8',
            'device_id' => 'nullable|integer',
        ]);

        $deviceId = $request->input('device_id', 1);

        if (!$this->connectToDevice($deviceId)) {
            return response()->json([
                'success' => false,
                'message' => 'فشل الاتصال بالجهاز',
            ], 500);
        }

        $result = $this->mikrotikService->createSimpleQueue(
            $request->name,
            $request->target,
            $request->max_limit,
            $request->limit_at,
            $request->priority ?? 1
        );

        return response()->json([
            'success' => $result,
            'message' => $result ? 'تم إنشاء الـ Queue بنجاح' : 'فشل إنشاء الـ Queue',
        ]);
    }

    public function updateQueue(Request $request, string $name): JsonResponse
    {
        $request->validate([
            'max_limit' => 'nullable|string',
            'limit_at' => 'nullable|string',
            'priority' => 'nullable|integer|min:1|max:8',
            'device_id' => 'nullable|integer',
        ]);

        $deviceId = $request->input('device_id', 1);

        if (!$this->connectToDevice($deviceId)) {
            return response()->json([
                'success' => false,
                'message' => 'فشل الاتصال بالجهاز',
            ], 500);
        }

        $result = $this->mikrotikService->updateSimpleQueue($name, $request->only([
            'max_limit',
            'limit_at',
            'priority'
        ]));

        return response()->json([
            'success' => $result,
            'message' => $result ? 'تم تحديث الـ Queue بنجاح' : 'فشل تحديث الـ Queue',
        ]);
    }

    public function deleteQueue(Request $request, string $name): JsonResponse
    {
        $deviceId = $request->input('device_id', 1);

        if (!$this->connectToDevice($deviceId)) {
            return response()->json([
                'success' => false,
                'message' => 'فشل الاتصال بالجهاز',
            ], 500);
        }

        $result = $this->mikrotikService->deleteSimpleQueue($name);

        return response()->json([
            'success' => $result,
            'message' => $result ? 'تم حذف الـ Queue بنجاح' : 'فشل حذف الـ Queue',
        ]);
    }

    public function toggleQueue(Request $request, string $name): JsonResponse
    {
        $deviceId = $request->input('device_id', 1);
        $action = $request->input('action', 'disable'); // disable | enable

        if (!$this->connectToDevice($deviceId)) {
            return response()->json([
                'success' => false,
                'message' => 'فشل الاتصال بالجهاز',
            ], 500);
        }

        $result = $action === 'enable'
            ? $this->mikrotikService->enableSimpleQueue($name)
            : $this->mikrotikService->disableSimpleQueue($name);

        return response()->json([
            'success' => $result,
            'message' => $result ? "تم {$action} الـ Queue بنجاح" : "فشل {$action} الـ Queue",
        ]);
    }

    // ========== إدارة الـ Firewall ==========

    public function getFirewallRules(Request $request): JsonResponse
    {
        $deviceId = $request->input('device_id', 1);

        if (!$this->connectToDevice($deviceId)) {
            return response()->json([
                'success' => false,
                'message' => 'فشل الاتصال بالجهاز',
            ], 500);
        }

        $rules = $this->mikrotikService->getFirewallRules();

        // 🔥 تنظيف البيانات
        $rules = $this->cleanUtf8($rules);

        return response()->json([
            'success' => true,
            'data' => $rules,
            'count' => count($rules),
        ]);
    }

    public function createFirewallRule(Request $request): JsonResponse
    {
        $request->validate([
            'chain' => 'required|string|in:input,output,forward',
            'action' => 'required|string|in:accept,drop,reject,log',
            'src_address' => 'nullable|string',
            'dst_address' => 'nullable|string',
            'protocol' => 'nullable|string',
            'dst_port' => 'nullable|string',
            'comment' => 'nullable|string',
            'device_id' => 'nullable|integer',
        ]);

        $deviceId = $request->input('device_id', 1);

        if (!$this->connectToDevice($deviceId)) {
            return response()->json([
                'success' => false,
                'message' => 'فشل الاتصال بالجهاز',
            ], 500);
        }

        $result = $this->mikrotikService->createFirewallRule($request->all());

        return response()->json([
            'success' => $result,
            'message' => $result ? 'تم إنشاء القاعدة بنجاح' : 'فشل إنشاء القاعدة',
        ]);
    }

    public function deleteFirewallRule(Request $request, string $id): JsonResponse
    {
        $deviceId = $request->input('device_id', 1);

        if (!$this->connectToDevice($deviceId)) {
            return response()->json([
                'success' => false,
                'message' => 'فشل الاتصال بالجهاز',
            ], 500);
        }

        $result = $this->mikrotikService->deleteFirewallRule($id);

        return response()->json([
            'success' => $result,
            'message' => $result ? 'تم حذف القاعدة بنجاح' : 'فشل حذف القاعدة',
        ]);
    }

    // ========== إدارة الـ NAT ==========

    public function getNATRules(Request $request): JsonResponse
    {
        $deviceId = $request->input('device_id', 1);

        if (!$this->connectToDevice($deviceId)) {
            return response()->json([
                'success' => false,
                'message' => 'فشل الاتصال بالجهاز',
            ], 500);
        }

        $rules = $this->mikrotikService->getNATRules();

        return response()->json([
            'success' => true,
            'data' => $rules,
            'count' => count($rules),
        ]);
    }

    // ========== إدارة DHCP ==========

    public function getDHCPLeases(Request $request): JsonResponse
    {
        $deviceId = $request->input('device_id', 1);

        if (!$this->connectToDevice($deviceId)) {
            return response()->json([
                'success' => false,
                'message' => 'فشل الاتصال بالجهاز',
            ], 500);
        }

        $leases = $this->mikrotikService->getDHCPLeases();

        return response()->json([
            'success' => true,
            'data' => $leases,
            'count' => count($leases),
        ]);
    }

    public function addDHCPLease(Request $request): JsonResponse
    {
        $request->validate([
            'address' => 'required|string',
            'mac_address' => 'required|string',
            'hostname' => 'nullable|string',
            'device_id' => 'nullable|integer',
        ]);

        $deviceId = $request->input('device_id', 1);

        if (!$this->connectToDevice($deviceId)) {
            return response()->json([
                'success' => false,
                'message' => 'فشل الاتصال بالجهاز',
            ], 500);
        }

        $result = $this->mikrotikService->addDHCPLease(
            $request->address,
            $request->mac_address,
            $request->hostname
        );

        return response()->json([
            'success' => $result,
            'message' => $result ? 'تم إضافة الـ Lease بنجاح' : 'فشل إضافة الـ Lease',
        ]);
    }

    public function deleteDHCPLease(Request $request, string $id): JsonResponse
    {
        $deviceId = $request->input('device_id', 1);

        if (!$this->connectToDevice($deviceId)) {
            return response()->json([
                'success' => false,
                'message' => 'فشل الاتصال بالجهاز',
            ], 500);
        }

        $result = $this->mikrotikService->deleteDHCPLease($id);

        return response()->json([
            'success' => $result,
            'message' => $result ? 'تم حذف الـ Lease بنجاح' : 'فشل حذف الـ Lease',
        ]);
    }

    /**
     * تنظيف البيانات من الأحرف غير الصالحة لـ UTF-8
     */
    protected function cleanUtf8($data)
    {
        if (is_array($data)) {
            return array_map([$this, 'cleanUtf8'], $data);
        }

        if (is_string($data)) {
            return mb_convert_encoding($data, 'UTF-8', 'UTF-8');
        }

        return $data;
    }
}
