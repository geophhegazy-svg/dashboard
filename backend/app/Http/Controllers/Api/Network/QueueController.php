<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Network;

use App\Http\Controllers\Controller;
use App\Models\NetworkDevice;
use App\Services\Network\NetworkManager;
use Illuminate\Http\Request;

class QueueController extends Controller
{
    public function __construct(
        protected NetworkManager $networkManager
    ) {}


    /**
     * Resolve network provider for device.
     */
    protected function provider(int $deviceId)
    {
        $device = NetworkDevice::findOrFail($deviceId);

        $connected = $this->networkManager->connect($device);

        if (!$connected) {
            return null;
        }

        return $this->networkManager->provider();
    }



    /**
     * Display queues.
     */
    public function index(Request $request)
    {
        $deviceId = (int) $request->input('device_id', 1);

        $device = NetworkDevice::find($deviceId);

        $devices = NetworkDevice::where(
            'status',
            'active'
        )->get();


        $queues = [];

        $connected = false;


        if ($device) {

            $provider = $this->provider($deviceId);


            if ($provider) {

                $connected = true;


                $queues = $provider
                    ->queue()
                    ->getAll();
            }
        }


        return view(
            'queues.index',
            compact(
                'queues',
                'devices',
                'device',
                'connected'
            )
        );
    }



    /**
     * Create queue page.
     */
    public function create(Request $request)
    {
        $deviceId = (int) $request->input('device_id', 1);

        $device = NetworkDevice::find($deviceId);


        $devices = NetworkDevice::where(
            'status',
            'active'
        )->get();


        return view(
            'queues.create',
            compact(
                'devices',
                'device'
            )
        );
    }



    /**
     * Store queue.
     */
    public function store(Request $request)
    {
        $request->validate([

            'name' =>
            'required|string',

            'target' =>
            'required|string',

            'max_limit' =>
            'required|string',

            'limit_at' =>
            'nullable|string',

            'priority' =>
            'nullable|integer|min:1|max:8',

            'device_id' =>
            'required|integer|exists:network_devices,id',
        ]);


        $provider = $this->provider(
            (int) $request->device_id
        );


        if (!$provider) {

            return back()->with(
                'error',
                'فشل الاتصال بالجهاز'
            );
        }



        $result = $provider
            ->queue()
            ->create(

                $request->name,

                $request->target,

                $request->max_limit,

                $request->limit_at,

                $request->priority ?? 1
            );



        if ($result) {

            return redirect()
                ->route(
                    'queues.index',
                    [
                        'device_id' =>
                        $request->device_id
                    ]
                )
                ->with(
                    'success',
                    'تم إنشاء الـ Queue بنجاح'
                );
        }


        return back()->with(
            'error',
            'فشل إنشاء الـ Queue'
        );
    }




    /**
     * Edit queue.
     */
    public function edit(
        Request $request,
        string $name
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



        if (!$provider) {

            return back()->with(
                'error',
                'فشل الاتصال بالجهاز'
            );
        }



        $queue = $provider
            ->queue()
            ->find($name);



        if (!$queue) {

            return redirect()
                ->route(
                    'queues.index',
                    [
                        'device_id' =>
                        $deviceId
                    ]
                )
                ->with(
                    'error',
                    'الـ Queue غير موجودة'
                );
        }



        return view(
            'queues.edit',
            compact(
                'queue',
                'devices',
                'device',
                'name'
            )
        );
    }




    /**
     * Update queue.
     */
    public function update(
        Request $request,
        string $name
    ) {

        $request->validate([

            'max_limit' =>
            'nullable|string',

            'limit_at' =>
            'nullable|string',

            'priority' =>
            'nullable|integer|min:1|max:8',

            'comment' =>
            'nullable|string',

            'device_id' =>
            'required|integer|exists:network_devices,id',
        ]);



        $provider = $this->provider(
            (int) $request->device_id
        );



        if (!$provider) {

            return back()->with(
                'error',
                'فشل الاتصال بالجهاز'
            );
        }



        $result = $provider
            ->queue()
            ->update(
                $name,
                $request->only([
                    'max_limit',
                    'limit_at',
                    'priority',
                    'comment',
                ])
            );



        if ($result) {

            return redirect()
                ->route(
                    'queues.index',
                    [
                        'device_id' =>
                        $request->device_id
                    ]
                )
                ->with(
                    'success',
                    'تم تحديث الـ Queue بنجاح'
                );
        }



        return back()->with(
            'error',
            'فشل تحديث الـ Queue'
        );
    }




    /**
     * Enable / Disable queue.
     */
    public function toggle(
        Request $request,
        string $name
    ) {

        $deviceId = (int) $request->input(
            'device_id',
            1
        );


        $action = $request->input(
            'action',
            'disable'
        );



        $provider = $this->provider($deviceId);



        if (!$provider) {

            return back()->with(
                'error',
                'فشل الاتصال بالجهاز'
            );
        }



        $result = $action === 'enable'

            ? $provider
            ->queue()
            ->enable($name)

            : $provider
            ->queue()
            ->disable($name);



        if ($result) {

            return back()->with(
                'success',
                "تم {$action} الـ Queue بنجاح"
            );
        }



        return back()->with(
            'error',
            "فشل {$action} الـ Queue"
        );
    }





    /**
     * Delete queue.
     */
    public function destroy(
        Request $request,
        string $name
    ) {

        $deviceId = (int) $request->input(
            'device_id',
            1
        );



        $provider = $this->provider($deviceId);



        if (!$provider) {

            return back()->with(
                'error',
                'فشل الاتصال بالجهاز'
            );
        }



        $result = $provider
            ->queue()
            ->delete($name);



        if ($result) {

            return back()->with(
                'success',
                'تم حذف الـ Queue بنجاح'
            );
        }



        return back()->with(
            'error',
            'فشل حذف الـ Queue'
        );
    }
}
