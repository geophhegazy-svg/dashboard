<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\NetworkDevice;
use App\Services\Network\NetworkManager;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class DhcpApiController extends Controller
{
    public function __construct(
        protected NetworkManager $networkManager
    ) {}

    protected function provider(int $deviceId)
    {
        $device = NetworkDevice::findOrFail($deviceId);

        if (! $this->networkManager->connect($device)) {
            abort(500, 'Unable to connect to network device.');
        }

        return $this->networkManager->provider();
    }

    public function index(Request $request): JsonResponse
    {
        $provider = $this->provider(
            (int) $request->input('device_id', 1)
        );

        $leases = $provider
            ->dhcp()
            ->getAll();

        return response()->json([
            'success' => true,
            'count'   => count($leases),
            'data'    => $leases,
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'address'     => 'required|string',
            'mac_address' => 'required|string',
            'hostname'    => 'nullable|string',
            'comment'     => 'nullable|string',
            'server'      => 'nullable|string',
            'device_id'   => 'nullable|integer',
        ]);

        $provider = $this->provider(
            (int) $request->input('device_id', 1)
        );

        $result = $provider
            ->dhcp()
            ->create(
                $request->address,
                $request->mac_address,
                $request->hostname,
                array_filter([
                    'comment' => $request->comment,
                    'server'  => $request->server,
                ])
            );

        return response()->json([
            'success' => $result,
            'message' => $result
                ? 'تم إضافة الـ Lease بنجاح'
                : 'فشل إضافة الـ Lease',
        ]);
    }

    public function update(
        Request $request,
        string $id
    ): JsonResponse {

        $request->validate([
            'address'     => 'nullable|string',
            'mac_address' => 'nullable|string',
            'hostname'    => 'nullable|string',
            'comment'     => 'nullable|string',
            'device_id'   => 'nullable|integer',
        ]);

        $provider = $this->provider(
            (int) $request->input('device_id', 1)
        );

        $result = $provider
            ->dhcp()
            ->update(
                $id,
                array_filter(
                    $request->only([
                        'address',
                        'mac_address',
                        'hostname',
                        'comment',
                    ]),
                    static fn($value) => $value !== null && $value !== ''
                )
            );

        return response()->json([
            'success' => $result,
            'message' => $result
                ? 'تم تحديث الـ Lease بنجاح'
                : 'فشل تحديث الـ Lease',
        ]);
    }

    /**
     * Delete DHCP lease.
     */
    public function destroy(
        Request $request,
        string $id
    ): JsonResponse {

        $provider = $this->provider(
            (int) $request->input('device_id', 1)
        );

        $result = $provider
            ->dhcp()
            ->delete($id);

        return response()->json([
            'success' => $result,
            'message' => $result
                ? 'تم حذف الـ Lease بنجاح'
                : 'فشل حذف الـ Lease',
        ]);
    }
}

