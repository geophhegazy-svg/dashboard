<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Network;

use App\Http\Controllers\Controller;
use App\Modules\Network\Application\Actions\CreateQueueAction;
use App\Modules\Network\Application\Actions\DeleteQueueAction;
use App\Modules\Network\Application\Actions\ToggleQueueAction;
use App\Modules\Network\Application\Actions\UpdateQueueAction;
use App\Modules\Network\Application\Contracts\NetworkManagerInterface;
use App\Modules\Network\Infrastructure\Persistence\Models\NetworkDevice;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

final class QueueApiController extends Controller
{
    public function __construct(
        private readonly NetworkManagerInterface $networkManager,
        private readonly CreateQueueAction $createQueue,
        private readonly UpdateQueueAction $updateQueue,
        private readonly ToggleQueueAction $toggleQueue,
        private readonly DeleteQueueAction $deleteQueue,
    ) {
    }

    public function index(Request $request): JsonResponse
    {
        $this->authorize('queue.view');

        $request->validate([
            'device_id' => ['required', 'integer'],
        ]);

        $provider = $this->connect($request);

        if ($provider === null) {
            return $this->connectionFailed();
        }

        return response()->json([
            'data' => $provider->queue()->getAll(),
        ]);
    }

    public function show(Request $request, string $name): JsonResponse
    {
        $this->authorize('queue.view');

        $provider = $this->connect($request);

        if ($provider === null) {
            return $this->connectionFailed();
        }

        $queue = $provider->queue()->find($name);

        if ($queue === null) {
            return response()->json([
                'message' => 'Queue not found.',
            ], 404);
        }

        return response()->json([
            'data' => $queue,
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        $this->authorize('queue.create');

        $validated = $request->validate([
            'device_id' => ['required', 'integer', 'exists:network_devices,id'],
            'name' => ['required', 'string', 'max:255'],
            'target' => ['required', 'string', 'max:255'],
            'max_limit' => ['required', 'string', 'max:100'],
            'limit_at' => ['nullable', 'string', 'max:100'],
            'priority' => ['nullable', 'integer', 'min:1', 'max:8'],
            'options' => ['nullable', 'array'],
        ]);

        $success = $this->createQueue->execute(
            $validated['device_id'],
            $validated['name'],
            $validated['target'],
            $validated['max_limit'],
            $validated['limit_at'] ?? null,
            $validated['priority'] ?? 1,
            $validated['options'] ?? [],
        );

        return $this->mutationResponse($success, 'Queue created.');
    }

    public function update(Request $request, string $name): JsonResponse
    {
        $this->authorize('queue.update');

        $validated = $request->validate([
            'device_id' => ['required', 'integer', 'exists:network_devices,id'],
            'data' => ['required', 'array'],
        ]);

        $success = $this->updateQueue->execute(
            $validated['device_id'],
            $name,
            $validated['data'],
        );

        return $this->mutationResponse($success, 'Queue updated.');
    }

    public function toggle(Request $request, string $name): JsonResponse
    {
        $this->authorize('queue.toggle');

        $validated = $request->validate([
            'device_id' => ['required', 'integer', 'exists:network_devices,id'],
            'action' => ['required', 'in:enable,disable'],
        ]);

        $success = $this->toggleQueue->execute(
            $validated['device_id'],
            $name,
            $validated['action'],
        );

        return $this->mutationResponse($success, 'Queue state updated.');
    }

    public function destroy(Request $request, string $name): JsonResponse
    {
        $this->authorize('queue.delete');

        $validated = $request->validate([
            'device_id' => ['required', 'integer', 'exists:network_devices,id'],
        ]);

        $success = $this->deleteQueue->execute(
            $validated['device_id'],
            $name,
        );

        return $this->mutationResponse($success, 'Queue deleted.');
    }

    public function usage(Request $request): JsonResponse
    {
        $this->authorize('queue.view');

        $provider = $this->connect($request);

        if ($provider === null) {
            return $this->connectionFailed();
        }

        return response()->json([
            'data' => $provider->queue()->getUsage(),
        ]);
    }

    public function statistics(Request $request, string $name): JsonResponse
    {
        $this->authorize('queue.view');

        $provider = $this->connect($request);

        if ($provider === null) {
            return $this->connectionFailed();
        }

        return response()->json([
            'data' => $provider->queue()->statistics($name),
        ]);
    }

    public function resetCounters(Request $request, string $name): JsonResponse
    {
        $this->authorize('queue.update');

        $validated = $request->validate([
            'device_id' => ['required', 'integer', 'exists:network_devices,id'],
        ]);

        $provider = $this->connectDevice($validated['device_id']);

        if ($provider === null) {
            return $this->connectionFailed();
        }

        $success = $provider->queue()->resetCounters($name);

        return $this->mutationResponse($success, 'Queue counters reset.');
    }

    private function connect(Request $request): mixed
    {
        $deviceId = $request->integer('device_id');

        if ($deviceId <= 0) {
            $deviceId = (int) NetworkDevice::query()
                ->where('status', 'active')
                ->value('id');
        }

        return $deviceId > 0
            ? $this->connectDevice($deviceId)
            : null;
    }

    private function connectDevice(int $deviceId): mixed
    {
        if (! $this->networkManager->connect($deviceId)) {
            return null;
        }

        return $this->networkManager->provider();
    }

    private function connectionFailed(): JsonResponse
    {
        return response()->json([
            'message' => 'Unable to connect to the network device.',
        ], 503);
    }

    private function mutationResponse(
        bool $success,
        string $message,
    ): JsonResponse {
        return $success
            ? response()->json(['success' => true, 'message' => $message])
            : response()->json([
                'success' => false,
                'message' => 'Operation failed.',
            ], 503);
    }
}
