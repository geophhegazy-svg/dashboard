<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Network;

use App\Http\Controllers\Controller;
use App\Models\NetworkDevice;
use App\Services\Network\NetworkManager;
use Illuminate\Http\Request;

class DHCPController extends Controller
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

    public function index(Request $request)
    {
        $deviceId = (int) $request->input('device_id', 1);

        $device = NetworkDevice::find($deviceId);

        $devices = NetworkDevice::where(
            'status',
            'active'
        )->get();

        $leases = [];
        $connected = false;
        $pagination = [];

        if ($device) {

            $provider = $this->provider($device->id);

            $connected = $this->networkManager->connected();

            if ($connected) {

                $allLeases = $provider
                    ->dhcp()
                    ->getAll();

                $perPage = 50;

                $currentPage = (int) $request->input(
                    'page',
                    1
                );

                $offset = ($currentPage - 1) * $perPage;

                $leases = array_slice(
                    $allLeases,
                    $offset,
                    $perPage
                );

                $total = count($allLeases);

                $lastPage = (int) ceil(
                    $total / $perPage
                );

                $pagination = [
                    'current_page' => $currentPage,
                    'last_page' => $lastPage,
                    'per_page' => $perPage,
                    'total' => $total,
                    'from' => $offset + 1,
                    'to' => min(
                        $offset + $perPage,
                        $total
                    ),
                ];
            }
        }

        return view(
            'dhcp.index',
            compact(
                'leases',
                'devices',
                'device',
                'connected',
                'pagination'
            )
        );
    }

    public function create(Request $request)
    {
        $deviceId = (int) $request->input(
            'device_id',
            1
        );

        $device = NetworkDevice::find($deviceId);

        $devices = NetworkDevice::where(
            'status',
            'active'
        )->get();

        return view(
            'dhcp.create',
            compact(
                'devices',
                'device'
            )
        );
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

        $provider = $this->provider(
            (int) $request->device_id
        );

        $result = $provider
            ->dhcp()
            ->create(
                $request->address,
                $request->mac_address,
                $request->hostname,
                [
                    'comment' => $request->comment,
                ]
            );

        if ($result) {

            return redirect()
                ->route(
                    'dhcp.index',
                    [
                        'device_id' => $request->device_id,
                    ]
                )
                ->with(
                    'success',
                    'تم إضافة عقد الإيجار بنجاح'
                );
        }

        return back()->with(
            'error',
            'فشل إضافة عقد الإيجار'
        );
    }

    public function edit(
        Request $request,
        string $id
    ) {

        $deviceId = (int) $request->input(
            'device_id',
            1
        );

        $device = NetworkDevice::find($deviceId);

        $devices = NetworkDevice::where(
            'status',
            'active'
        )->get();

        $provider = $this->provider($deviceId);

        $lease = $provider
            ->dhcp()
            ->find($id);

        if ($lease === null) {

            return redirect()
                ->route(
                    'dhcp.index',
                    [
                        'device_id' => $deviceId,
                    ]
                )
                ->with(
                    'error',
                    'عقد الإيجار غير موجود'
                );
        }

        return view(
            'dhcp.edit',
            compact(
                'lease',
                'devices',
                'device',
                'id'
            )
        );
    }

    public function update(
        Request $request,
        string $id
    ) {

        $request->validate([
            'address' => 'nullable|string',
            'mac_address' => 'nullable|string',
            'hostname' => 'nullable|string',
            'comment' => 'nullable|string',
            'device_id' => 'required|integer|exists:network_devices,id',
        ]);

        $provider = $this->provider(
            (int) $request->device_id
        );

        $data = array_filter(
            $request->only([
                'address',
                'mac_address',
                'hostname',
                'comment',
            ]),
            static fn($value) => $value !== null && $value !== ''
        );

        $result = $provider
            ->dhcp()
            ->update(
                $id,
                $data
            );

        if ($result) {

            return redirect()
                ->route(
                    'dhcp.index',
                    [
                        'device_id' => $request->device_id,
                    ]
                )
                ->with(
                    'success',
                    'تم تحديث عقد الإيجار بنجاح'
                );
        }

        return back()->with(
            'error',
            'فشل تحديث عقد الإيجار'
        );
    }

    public function destroy(
        Request $request,
        string $id
    ) {

        $provider = $this->provider(
            (int) $request->input(
                'device_id',
                1
            )
        );

        $result = $provider
            ->dhcp()
            ->delete($id);

        if ($result) {

            return back()->with(
                'success',
                'تم حذف عقد الإيجار بنجاح'
            );
        }

        return back()->with(
            'error',
            'فشل حذف عقد الإيجار'
        );
    }
}
