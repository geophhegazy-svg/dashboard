<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Network;

use App\Http\Controllers\Controller;
use App\Modules\Network\Application\Actions\CreateDhcpLeaseAction;
use App\Modules\Network\Application\Actions\DeleteDhcpLeaseAction;
use App\Modules\Network\Application\Actions\UpdateDhcpLeaseAction;
use App\Modules\Network\Application\Contracts\NetworkManagerInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

final class DhcpApiController extends Controller
{
    public function __construct(
        private readonly NetworkManagerInterface $networkManager,
        private readonly CreateDhcpLeaseAction $createLease,
        private readonly UpdateDhcpLeaseAction $updateLease,
        private readonly DeleteDhcpLeaseAction $deleteLease,
    ) {
    }

    public function index(Request $request): JsonResponse
    {
        $this->authorize('dhcp.view');

        $request->validate([
            'device_id' => ['required', 'integer'],
        ]);

        $provider = $this->connect($request);

        if ($provider === null) {
            return $this->connectionFailed();
        }

        $leases = $provider->dhcp()->getAll();

        // Use comments only for display; do not modify router records.
        $hotspotNamesByMac = [];
        
        try {
            foreach ($provider->hotspot()->getUsers() as $hotspotUser) {
                $mac = $this->normalizeMacAddress($hotspotUser['mac-address'] ?? '');
                $comment = trim((string) ($hotspotUser['comment'] ?? ''));
        
                if ($mac !== '' && $comment !== '' && ! array_key_exists($mac, $hotspotNamesByMac)) {
                    $hotspotNamesByMac[$mac] = $comment;
                }
            }
        } catch (\Throwable) {
            // Keep DHCP results available even if hotspot lookup fails.
            $hotspotNamesByMac = [];
        }
        
        foreach ($leases as &$lease) {
            $leaseComment = trim((string) ($lease['comment'] ?? ''));
            $mac = $this->normalizeMacAddress($lease['mac-address'] ?? '');
        
            $lease['display_name'] = $leaseComment !== ''
                ? $leaseComment
                : ($hotspotNamesByMac[$mac] ?? null);
        }
        unset($lease);
        
        return response()->json([
            'data' => $leases,
        ]);
    }

    public function show(Request $request, string $id): JsonResponse
    {
        $this->authorize('dhcp.view');

        $provider = $this->connect($request);

        if ($provider === null) {
            return $this->connectionFailed();
        }

        $lease = $provider->dhcp()->find($id);

        if ($lease === null) {
            return response()->json([
                'message' => 'DHCP lease not found.',
            ], 404);
        }

        return response()->json([
            'data' => $lease,
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        $this->authorize('dhcp.create');

        $validated = $request->validate([
            'device_id' => ['required', 'integer', 'exists:network_devices,id'],
            'address' => ['required', 'string', 'max:255'],
            'mac_address' => ['required', 'string', 'max:255'],
            'hostname' => ['nullable', 'string', 'max:255'],
            'options' => ['nullable', 'array'],
        ]);

        $success = $this->createLease->execute(
            $validated['device_id'],
            $validated['address'],
            $validated['mac_address'],
            $validated['hostname'] ?? null,
            $validated['options'] ?? [],
        );

        return $this->mutationResponse($success, 'DHCP lease created.');
    }

    public function update(Request $request, string $id): JsonResponse
    {
        $this->authorize('dhcp.update');

        $validated = $request->validate([
            'device_id' => ['required', 'integer', 'exists:network_devices,id'],
            'data' => ['required', 'array'],
        ]);

        $success = $this->updateLease->execute(
            $validated['device_id'],
            $id,
            $validated['data'],
        );

        return $this->mutationResponse($success, 'DHCP lease updated.');
    }

    public function destroy(Request $request, string $id): JsonResponse
    {
        $this->authorize('dhcp.delete');

        $validated = $request->validate([
            'device_id' => ['required', 'integer', 'exists:network_devices,id'],
        ]);

        $success = $this->deleteLease->execute(
            $validated['device_id'],
            $id,
        );

        return $this->mutationResponse($success, 'DHCP lease deleted.');
    }

    public function makeStatic(Request $request, string $id): JsonResponse
    {
        $this->authorize('dhcp.update');

        $provider = $this->connect($request);

        if ($provider === null) {
            return $this->connectionFailed();
        }

        $success = $provider->dhcp()->makeStatic($id);

        return $this->mutationResponse($success, 'DHCP lease made static.');
    }

    public function removeStatic(Request $request, string $id): JsonResponse
    {
        $this->authorize('dhcp.update');

        $provider = $this->connect($request);

        if ($provider === null) {
            return $this->connectionFailed();
        }

        $success = $provider->dhcp()->removeStatic($id);

        return $this->mutationResponse($success, 'DHCP lease made dynamic.');
    }

    public function statistics(Request $request): JsonResponse
    {
        $this->authorize('dhcp.view');

        $provider = $this->connect($request);

        if ($provider === null) {
            return $this->connectionFailed();
        }

        return response()->json([
            'data' => $provider->dhcp()->statistics(),
        ]);
    }

    private function normalizeMacAddress(mixed $value): string
    {
        return strtolower(
            preg_replace('/[^a-f0-9]/i', '', trim((string) $value)) ?? ''
        );
    }
    private function connect(Request $request): mixed
    {
        $deviceId = $request->integer('device_id');

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
            ? response()->json(['success' => true, 'message' => $message])
            : response()->json([
                'success' => false,
                'message' => 'Operation failed.',
            ], 503);
    }
}
