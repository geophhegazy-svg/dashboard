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
    ) {}


    /**
     * Resolve network provider.
     */
    protected function provider(int $deviceId)
    {
        $device = NetworkDevice::findOrFail($deviceId);


        if (! $this->networkManager->connect($device)) {
            return null;
        }


        return $this->networkManager->provider();
    }



    /**
     * Display firewall rules.
     */
    public function index(Request $request)
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



        $rules = [];

        $connected = false;



        if ($device) {

            $provider = $this->provider($deviceId);


            if ($provider) {

                $connected = true;


                $rules = $provider
                    ->firewall()
                    ->getAll();
            }
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




    /**
     * Create firewall rule page.
     */
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
            'firewall.create',
            compact(
                'devices',
                'device'
            )
        );
    }





    /**
     * Store firewall rule.
     */
    public function store(Request $request)
    {
        $request->validate([

            'chain' =>
            'required|string',

            'action' =>
            'required|string',

            'src_address' =>
            'nullable|string',

            'dst_address' =>
            'nullable|string',

            'protocol' =>
            'nullable|string',

            'dst_port' =>
            'nullable|string',

            'comment' =>
            'nullable|string',

            'device_id' =>
            'required|integer|exists:network_devices,id',

        ]);



        $provider = $this->provider(
            (int) $request->device_id
        );



        if (! $provider) {

            return back()->with(
                'error',
                'فشل الاتصال بالجهاز'
            );
        }



        $result = $provider
            ->firewall()
            ->create(
                $request->only([
                    'chain',
                    'action',
                    'src_address',
                    'dst_address',
                    'protocol',
                    'dst_port',
                    'comment',
                ])
            );



        if ($result) {

            return redirect()
                ->route(
                    'firewall.index',
                    [
                        'device_id' =>
                        $request->device_id
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





    /**
     * Edit firewall rule.
     */
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



        if (! $provider) {

            return back()->with(
                'error',
                'فشل الاتصال بالجهاز'
            );
        }



        $rule = $provider
            ->firewall()
            ->find($id);



        if (! $rule) {

            return redirect()
                ->route(
                    'firewall.index',
                    [
                        'device_id' => $deviceId
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





    /**
     * Update firewall rule.
     */
    public function update(
        Request $request,
        string $id
    ) {

        $request->validate([

            'chain' =>
            'nullable|string',

            'action' =>
            'nullable|string',

            'src_address' =>
            'nullable|string',

            'dst_address' =>
            'nullable|string',

            'protocol' =>
            'nullable|string',

            'dst_port' =>
            'nullable|string',

            'comment' =>
            'nullable|string',

            'device_id' =>
            'required|integer|exists:network_devices,id',

        ]);



        $provider = $this->provider(
            (int) $request->device_id
        );



        if (! $provider) {

            return back()->with(
                'error',
                'فشل الاتصال بالجهاز'
            );
        }



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
                    ])
                )
            );



        if ($result) {

            return redirect()
                ->route(
                    'firewall.index',
                    [
                        'device_id' => $request->device_id
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





    /**
     * Delete firewall rule.
     */
    public function destroy(
        Request $request,
        string $id
    ) {

        $deviceId = (int) $request->input(
            'device_id',
            1
        );


        $provider = $this->provider($deviceId);



        if (! $provider) {

            return back()->with(
                'error',
                'فشل الاتصال بالجهاز'
            );
        }



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
