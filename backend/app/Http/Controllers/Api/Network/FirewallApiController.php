<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Network;

use App\Http\Controllers\Controller;
use App\Modules\Network\Application\Actions\CreateFirewallRuleAction;
use App\Modules\Network\Application\Actions\DeleteFirewallRuleAction;
use App\Modules\Network\Application\Actions\UpdateFirewallRuleAction;
use App\Modules\Network\Application\Contracts\NetworkManagerInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

final class FirewallApiController extends Controller
{
    public function __construct(
        private readonly NetworkManagerInterface $networkManager,
        private readonly CreateFirewallRuleAction $createRule,
        private readonly UpdateFirewallRuleAction $updateRule,
        private readonly DeleteFirewallRuleAction $deleteRule,
    ) {
    }

    public function index(Request $request): JsonResponse
    {
        $this->authorize('firewall.view');

        $request->validate([
            'device_id' => ['required', 'integer'],
        ]);

        $provider = $this->connect($request);

        if ($provider === null) {
            return $this->connectionFailed();
        }

        return response()->json([
            'data' => $provider->firewall()->getRules(),
        ]);
    }

    public function show(Request $request, string $comment): JsonResponse
    {
        $this->authorize('firewall.view');

        $provider = $this->connect($request);

        if ($provider === null) {
            return $this->connectionFailed();
        }

        $rule = $provider->firewall()->find($comment);

        if ($rule === null) {
            return response()->json([
                'message' => 'Firewall rule not found.',
            ], 404);
        }

        return response()->json([
            'data' => $rule,
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        $this->authorize('firewall.create');

        $validated = $request->validate([
            'device_id' => ['required', 'integer', 'exists:network_devices,id'],
            'attributes' => ['required', 'array'],
        ]);

        $success = $this->createRule->execute(
            $validated['device_id'],
            $validated['attributes'],
        );

        return $this->mutationResponse($success, 'Firewall rule created.');
    }

    public function update(Request $request, string $comment): JsonResponse
    {
        $this->authorize('firewall.update');

        $validated = $request->validate([
            'device_id' => ['required', 'integer', 'exists:network_devices,id'],
            'attributes' => ['required', 'array'],
        ]);

        $success = $this->updateRule->execute(
            $validated['device_id'],
            $comment,
            $validated['attributes'],
        );

        return $this->mutationResponse($success, 'Firewall rule updated.');
    }

    public function destroy(Request $request, string $comment): JsonResponse
    {
        $this->authorize('firewall.delete');

        $validated = $request->validate([
            'device_id' => ['required', 'integer', 'exists:network_devices,id'],
        ]);

        $success = $this->deleteRule->execute(
            $validated['device_id'],
            $comment,
        );

        return $this->mutationResponse($success, 'Firewall rule deleted.');
    }

    public function toggle(Request $request, string $comment): JsonResponse
    {
        $this->authorize('firewall.update');

        $validated = $request->validate([
            'device_id' => ['required', 'integer', 'exists:network_devices,id'],
            'action' => ['required', 'in:enable,disable'],
        ]);

        $provider = $this->connectDevice($validated['device_id']);

        if ($provider === null) {
            return $this->connectionFailed();
        }

        $success = $validated['action'] === 'enable'
            ? $provider->firewall()->enable($comment)
            : $provider->firewall()->disable($comment);

        return $this->mutationResponse($success, 'Firewall rule state updated.');
    }

    public function nat(Request $request): JsonResponse
    {
        $this->authorize('firewall.view');

        $provider = $this->connect($request);

        if ($provider === null) {
            return $this->connectionFailed();
        }

        return response()->json([
            'data' => $provider->firewall()->getNatRules(),
        ]);
    }

    public function natShow(Request $request, string $comment): JsonResponse
    {
        $this->authorize('firewall.view');

        $provider = $this->connect($request);

        if ($provider === null) {
            return $this->connectionFailed();
        }

        $rule = $provider->firewall()->findNat($comment);

        if ($rule === null) {
            return response()->json([
                'message' => 'NAT rule not found.',
            ], 404);
        }

        return response()->json([
            'data' => $rule,
        ]);
    }

    public function natStore(Request $request): JsonResponse
    {
        $this->authorize('firewall.create');

        $validated = $request->validate([
            'device_id' => ['required', 'integer', 'exists:network_devices,id'],
            'attributes' => ['required', 'array'],
        ]);

        $provider = $this->connectDevice($validated['device_id']);

        if ($provider === null) {
            return $this->connectionFailed();
        }

        $success = $provider->firewall()->createNat(
            $validated['attributes'],
        );

        return $this->mutationResponse($success, 'NAT rule created.');
    }

    public function natUpdate(
        Request $request,
        string $comment,
    ): JsonResponse {
        $this->authorize('firewall.update');

        $validated = $request->validate([
            'device_id' => ['required', 'integer', 'exists:network_devices,id'],
            'attributes' => ['required', 'array'],
        ]);

        $provider = $this->connectDevice($validated['device_id']);

        if ($provider === null) {
            return $this->connectionFailed();
        }

        $success = $provider->firewall()->updateNat(
            $comment,
            $validated['attributes'],
        );

        return $this->mutationResponse($success, 'NAT rule updated.');
    }

    public function natDestroy(
        Request $request,
        string $comment,
    ): JsonResponse {
        $this->authorize('firewall.delete');

        $validated = $request->validate([
            'device_id' => ['required', 'integer', 'exists:network_devices,id'],
        ]);

        $provider = $this->connectDevice($validated['device_id']);

        if ($provider === null) {
            return $this->connectionFailed();
        }

        $success = $provider->firewall()->deleteNat($comment);

        return $this->mutationResponse($success, 'NAT rule deleted.');
    }

    public function statistics(Request $request): JsonResponse
    {
        $this->authorize('firewall.view');

        $provider = $this->connect($request);

        if ($provider === null) {
            return $this->connectionFailed();
        }

        return response()->json([
            'data' => $provider->firewall()->statistics(),
        ]);
    }

    private function connect(Request $request): mixed
    {
        $deviceId = $request->integer('device_id');

        if ($deviceId <= 0) {
            return null;
        }

        return $this->connectDevice($deviceId);
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
