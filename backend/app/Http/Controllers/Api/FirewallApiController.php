<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\NetworkDevice;
use App\Services\Network\NetworkManager;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class FirewallApiController extends Controller
{
    public function __construct(
        protected NetworkManager $networkManager
    ) {
    }

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

        $rules = $provider
            ->firewall()
            ->getAll();

        return response()->json([
            'success' => true,
            'count'   => count($rules),
            'data'    => $rules,
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'chain'       => 'required|string',
            'action'      => 'required|string',
            'src_address' => 'nullable|string',
            'dst_address' => 'nullable|string',
            'protocol'    => 'nullable|string',
            'dst_port'    => 'nullable|string',
            'comment'     => 'nullable|string',
            'device_id'   => 'nullable|integer',
        ]);

        $provider = $this->provider(
            (int) $request->input('device_id', 1)
        );

        $result = $provider
            ->firewall()
            ->create(
                array_filter(
                    $request->only([
                        'chain',
                        'action',
                        'src_address',
                        'dst_address',
                        'protocol',
                        'dst_port',
                        'comment',
                    ]),
                    static fn ($value) => $value !== null && $value !== ''
                )
            );

        return response()->json([
            'success' => $result,
            'message' => $result
                ? 'تم إنشاء القاعدة بنجاح'
                : 'فشل إنشاء القاعدة',
        ]);
    }

    public function update(
        Request $request,
        string $id
    ): JsonResponse
    {
        $request->validate([
            'chain'       => 'nullable|string',
            'action'      => 'nullable|string',
            'src_address' => 'nullable|string',
            'dst_address' => 'nullable|string',
            'protocol'    => 'nullable|string',
            'dst_port'    => 'nullable|string',
            'comment'     => 'nullable|string',
            'device_id'   => 'nullable|integer',
        ]);

        $provider = $this->provider(
            (int) $request->input('device_id', 1)
        );

        $result = $provider
            ->firewall()
            ->update(
                $id,
                array_filter(
                    $request->only([
                        'chain',
                        'action',
                        'src_address',
                        'dst_address',
                        'protocol',
                        'dst_port',
                        'comment',
                    ]),
                    static fn ($value) => $value !== null && $value !== ''
                )
            );

        return response()->json([
            'success' => $result,
            'message' => $result
                ? 'تم تحديث القاعدة بنجاح'
                : 'فشل تحديث القاعدة',
        ]);
    }

    public function destroy(
        Request $request,
        string $id
    ): JsonResponse {

        $provider = $this->provider(
            (int) $request->input('device_id', 1)
        );

        $result = $provider
            ->firewall()
            ->delete($id);

        return response()->json([
            'success' => $result,
            'message' => $result
                ? 'تم حذف القاعدة بنجاح'
                : 'فشل حذف القاعدة',
        ]);
    }
}
