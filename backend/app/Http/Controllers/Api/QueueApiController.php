<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\NetworkDevice;
use App\Services\Network\NetworkManager;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class QueueApiController extends Controller
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

        $queues = $provider
            ->queue()
            ->getAll();

        return response()->json([
            'success' => true,
            'count'   => count($queues),
            'data'    => $queues,
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'name'       => 'required|string',
            'target'     => 'required|string',
            'max_limit'  => 'required|string',
            'limit_at'   => 'nullable|string',
            'priority'   => 'nullable|integer|min:1|max:8',
            'device_id'  => 'nullable|integer',
        ]);

        $provider = $this->provider(
            (int) $request->input('device_id', 1)
        );

        $result = $provider
            ->queue()
            ->create(
                $request->name,
                $request->target,
                $request->max_limit,
                $request->limit_at,
                $request->priority ?? 1
            );

        return response()->json([
            'success' => $result,
            'message' => $result
                ? 'تم إنشاء الـ Queue بنجاح'
                : 'فشل إنشاء الـ Queue',
        ]);
    }

    public function update(
        Request $request,
        string $name
    ): JsonResponse {

        $request->validate([
            'max_limit' => 'nullable|string',
            'limit_at'  => 'nullable|string',
            'priority'  => 'nullable|integer|min:1|max:8',
            'comment'   => 'nullable|string',
            'device_id' => 'nullable|integer',
        ]);

        $provider = $this->provider(
            (int) $request->input('device_id', 1)
        );

        $result = $provider
            ->queue()
            ->update(
                $name,
                array_filter(
                    $request->only([
                        'max_limit',
                        'limit_at',
                        'priority',
                        'comment',
                    ]),
                    static fn ($value) => $value !== null && $value !== ''
                )
            );

        return response()->json([
            'success' => $result,
            'message' => $result
                ? 'تم تحديث الـ Queue بنجاح'
                : 'فشل تحديث الـ Queue',
        ]);
    }

    public function toggle(
        Request $request,
        string $name
    ): JsonResponse {

        $provider = $this->provider(
            (int) $request->input('device_id', 1)
        );

        $action = $request->input(
            'action',
            'disable'
        );

        $result = $action === 'enable'
            ? $provider
            ->queue()
            ->enable($name)
            : $provider
            ->queue()
            ->disable($name);

        return response()->json([
            'success' => $result,
            'message' => $result
                ? "تم {$action} الـ Queue بنجاح"
                : "فشل {$action} الـ Queue",
        ]);
    }



    public function destroy(
        Request $request,
        string $name
    ): JsonResponse {

        $provider = $this->provider(
            (int) $request->input('device_id', 1)
        );

        $result = $provider
            ->queue()
            ->delete($name);

        return response()->json([
            'success' => $result,
            'message' => $result
                ? 'تم حذف الـ Queue بنجاح'
                : 'فشل حذف الـ Queue',
        ]);
    }
}
