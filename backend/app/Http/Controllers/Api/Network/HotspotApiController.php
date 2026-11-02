<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Network;

use App\Http\Controllers\Controller;
use App\Modules\Network\Application\Contracts\NetworkManagerInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

final class HotspotApiController extends Controller
{
    public function __construct(
        private readonly NetworkManagerInterface $networkManager,
    ) {
    }

    public function index(Request $request): JsonResponse
    {
        $this->authorize('mikrotik.hotspot.view');

        $request->validate([
            'device_id' => ['required', 'integer'],
        ]);

        $provider = $this->connect($request->integer('device_id'));

        if ($provider === null) {
            return $this->connectionFailed();
        }

        return response()->json([
            'data' => $provider->hotspot()->getUsers(),
        ]);
    }

    public function show(Request $request, string $username): JsonResponse
    {
        $this->authorize('mikrotik.hotspot.view');

        $validated = $request->validate([
            'device_id' => ['required', 'integer'],
        ]);

        $provider = $this->connect($validated['device_id']);

        if ($provider === null) {
            return $this->connectionFailed();
        }

        $user = $provider->hotspot()->findUser($username);

        if ($user === null) {
            return response()->json([
                'message' => 'HotSpot user not found.',
            ], 404);
        }

        return response()->json([
            'data' => $user,
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        $this->authorize('mikrotik.hotspot.create');

        $validated = $request->validate([
            'device_id' => ['required', 'integer'],
            'username' => ['required', 'string', 'max:255'],
            'password' => ['required', 'string', 'max:255'],
            'profile' => ['required', 'string', 'max:255'],
            'options' => ['nullable', 'array'],
        ]);

        $provider = $this->connect($validated['device_id']);

        if ($provider === null) {
            return $this->connectionFailed();
        }

        $success = $provider->hotspot()->createUser(
            $validated['username'],
            $validated['password'],
            $validated['profile'],
            $validated['options'] ?? [],
        );

        return $this->mutationResponse($success, 'HotSpot user created.');
    }

    public function update(Request $request, string $username): JsonResponse
    {
        $this->authorize('mikrotik.hotspot.update');

        $validated = $request->validate([
            'device_id' => ['required', 'integer'],
            'data' => ['required', 'array'],
        ]);

        $provider = $this->connect($validated['device_id']);

        if ($provider === null) {
            return $this->connectionFailed();
        }

        $success = $provider->hotspot()->updateUser(
            $username,
            $validated['data'],
        );

        return $this->mutationResponse($success, 'HotSpot user updated.');
    }

    public function destroy(Request $request, string $username): JsonResponse
    {
        $this->authorize('mikrotik.hotspot.delete');

        $validated = $request->validate([
            'device_id' => ['required', 'integer'],
        ]);

        $provider = $this->connect($validated['device_id']);

        if ($provider === null) {
            return $this->connectionFailed();
        }

        $success = $provider->hotspot()->deleteUser($username);

        return $this->mutationResponse($success, 'HotSpot user deleted.');
    }

    public function toggle(Request $request, string $username): JsonResponse
    {
        $this->authorize('mikrotik.hotspot.update');

        $validated = $request->validate([
            'device_id' => ['required', 'integer'],
            'action' => ['required', 'in:enable,disable'],
        ]);

        $provider = $this->connect($validated['device_id']);

        if ($provider === null) {
            return $this->connectionFailed();
        }

        $success = $validated['action'] === 'enable'
            ? $provider->hotspot()->enableUser($username)
            : $provider->hotspot()->disableUser($username);

        return $this->mutationResponse($success, 'HotSpot user state updated.');
    }

    public function disconnect(Request $request, string $username): JsonResponse
    {
        $this->authorize('mikrotik.hotspot.view');

        $validated = $request->validate([
            'device_id' => ['required', 'integer'],
        ]);

        $provider = $this->connect($validated['device_id']);

        if ($provider === null) {
            return $this->connectionFailed();
        }

        $success = $provider->hotspot()->disconnectUser($username);

        return $this->mutationResponse($success, 'HotSpot user disconnected.');
    }

    private function connect(int $deviceId): mixed
    {
        if ($deviceId <= 0) {
            return null;
        }

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
            ? response()->json([
                'success' => true,
                'message' => $message,
            ])
            : response()->json([
                'success' => false,
                'message' => 'Operation failed.',
            ], 503);
    }
}
