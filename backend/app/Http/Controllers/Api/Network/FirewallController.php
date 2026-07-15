<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Network;

use App\Http\Controllers\Controller;
use App\Models\NetworkDevice;
use App\Services\Network\NetworkManager;
use Illuminate\Http\Request;

class FirewallController extends Controller
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

        $rules = [];
        $connected = false;

        if ($device) {

            $provider = $this->provider($device->id);

            $connected = true;

            $rules = $provider
                ->firewall()
                ->getAll();
        }

        return view(
            'firewall.index',
            compact(
                'rules',
                'devices',
                'device',
                'connected'
            )
        );
    }

    public function create(Request $request)
    {
        $deviceId = (int) $request->input('device_id', 1);

        $device = NetworkDevice::find($deviceId);

        $devices = NetworkDevice::where(
            'status',
            'active'
        )->get();

        return view(
            'firewall.create',
            compact(
                'devices',
                'device'
            )
        );
    }
    public function store(Request $request)
    {
        $request->validate([
            'chain' => 'required|string|in:input,output,forward,hs-input,hs-unauth,hs-unauth-to',
            'action' => 'required|string|in:accept,drop,reject,log,jump,passthrough',
            'src_address' => 'nullable|string',
            'dst_address' => 'nullable|string',
            'protocol' => 'nullable|string',
            'dst_port' => 'nullable|string',
            'comment' => 'nullable|string',
            'device_id' => 'required|integer|exists:network_devices,id',
        ]);

        $provider = $this->provider(
            (int) $request->device_id
        );

        $result = $provider
            ->firewall()
            ->create(
                array_filter([
                    'chain'       => $request->chain,
                    'action'      => $request->action,
                    'src_address' => $request->src_address,
                    'dst_address' => $request->dst_address,
                    'protocol'    => $request->protocol,
                    'dst_port'    => $request->dst_port,
                    'comment'     => $request->comment,
                ], static fn($value) => $value !== null && $value !== '')
            );

        if ($result) {

            return redirect()
                ->route(
                    'firewall.index',
                    [
                        'device_id' => $request->device_id,
                    ]
                )
                ->with(
                    'success',
                    'تم إنشاء القاعدة بنجاح'
                );
        }

        return back()->with(
            'error',
            'فشل إنشاء القاعدة'
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

        $rule = $provider
            ->firewall()
            ->find($id);

        if ($rule === null) {

            return redirect()
                ->route(
                    'firewall.index',
                    [
                        'device_id' => $deviceId,
                    ]
                )
                ->with(
                    'error',
                    'القاعدة غير موجودة'
                );
        }

        return view(
            'firewall.edit',
            compact(
                'rule',
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
            'chain' => 'nullable|string|in:input,output,forward,hs-input,hs-unauth,hs-unauth-to',
            'action' => 'nullable|string|in:accept,drop,reject,log,jump,passthrough',
            'src_address' => 'nullable|string',
            'dst_address' => 'nullable|string',
            'protocol' => 'nullable|string',
            'dst_port' => 'nullable|string',
            'comment' => 'nullable|string',
            'device_id' => 'required|integer|exists:network_devices,id',
        ]);

        $provider = $this->provider(
            (int) $request->device_id
        );

        $data = array_filter(
            $request->only([
                'chain',
                'action',
                'src_address',
                'dst_address',
                'protocol',
                'dst_port',
                'comment',
            ]),
            static fn($value) => $value !== null && $value !== ''
        );

        $result = $provider
            ->firewall()
            ->update(
                $id,
                $data
            );

        if ($result) {

            return redirect()
                ->route(
                    'firewall.index',
                    [
                        'device_id' => $request->device_id,
                    ]
                )
                ->with(
                    'success',
                    'تم تحديث القاعدة بنجاح'
                );
        }

        return back()->with(
            'error',
            'فشل تحديث القاعدة'
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
            ->firewall()
            ->delete($id);

        if ($result) {

            return back()->with(
                'success',
                'تم حذف القاعدة بنجاح'
            );
        }

        return back()->with(
            'error',
            'فشل حذف القاعدة'
        );
    }
}
