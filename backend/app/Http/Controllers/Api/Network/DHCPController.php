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
    ) {}


    /**
     * Resolve provider for device.
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
     * Display DHCP leases.
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



        $leases = [];

        $connected = false;

        $pagination = [];



        if ($device) {

            $provider = $this->provider($deviceId);



            if ($provider) {

                $connected = true;


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



                $pagination = [

                    'current_page' =>
                    $currentPage,

                    'last_page' =>
                    (int) ceil($total / $perPage),

                    'per_page' =>
                    $perPage,

                    'total' =>
                    $total,

                    'from' =>
                    $offset + 1,

                    'to' =>
                    min(
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





    /**
     * Create DHCP lease page.
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
            'dhcp.create',
            compact(
                'devices',
                'device'
            )
        );
    }





    /**
     * Store DHCP lease.
     */
    public function store(Request $request)
    {
        $request->validate([

            'address' =>
            'required|string',

            'mac_address' =>
            'required|string',

            'hostname' =>
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
            ->dhcp()
            ->create(

                $request->address,

                $request->mac_address,

                $request->hostname,

                [
                    'comment' =>
                    $request->comment,
                ]
            );



        if ($result) {

            return redirect()
                ->route(
                    'dhcp.index',
                    [
                        'device_id' => $request->device_id
                    ]
                )
                ->with(
                    'success',
                    'تم إضافة DHCP Lease بنجاح'
                );
        }



        return back()->with(
            'error',
            'فشل إضافة DHCP Lease'
        );
    }





    /**
     * Edit DHCP lease.
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



        $lease = $provider
            ->dhcp()
            ->find($id);



        if (! $lease) {

            return redirect()
                ->route(
                    'dhcp.index',
                    [
                        'device_id' => $deviceId
                    ]
                )
                ->with(
                    'error',
                    'Lease غير موجود'
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





    /**
     * Update DHCP lease.
     */
    public function update(
        Request $request,
        string $id
    ) {

        $request->validate([

            'address' =>
            'nullable|string',

            'mac_address' =>
            'nullable|string',

            'hostname' =>
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
            ->dhcp()
            ->update(
                $id,
                array_filter(
                    $request->only([
                        'address',
                        'mac_address',
                        'hostname',
                        'comment',
                    ])
                )
            );



        if ($result) {

            return redirect()
                ->route(
                    'dhcp.index',
                    [
                        'device_id' => $request->device_id
                    ]
                )
                ->with(
                    'success',
                    'تم تحديث DHCP Lease بنجاح'
                );
        }



        return back()->with(
            'error',
            'فشل تحديث DHCP Lease'
        );
    }





    /**
     * Delete DHCP lease.
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
            ->dhcp()
            ->delete($id);



        if ($result) {

            return back()->with(
                'success',
                'تم حذف DHCP Lease بنجاح'
            );
        }



        return back()->with(
            'error',
            'فشل حذف DHCP Lease'
        );
    }
}
