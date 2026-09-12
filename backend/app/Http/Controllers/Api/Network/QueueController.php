<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Network;

use App\Http\Controllers\Controller;
use App\Modules\Network\Application\Actions\CreateQueueAction;
use App\Modules\Network\Application\Actions\UpdateQueueAction;
use App\Modules\Network\Application\Actions\ToggleQueueAction;
use App\Modules\Network\Application\Actions\DeleteQueueAction;
use App\Modules\Network\Application\Contracts\NetworkManagerInterface;
use App\Modules\Network\Domain\Contracts\NetworkDeviceRepositoryInterface;
use Illuminate\Http\Request;

class QueueController extends Controller
{
    public function __construct(
        protected NetworkManagerInterface $networkManager,
        protected NetworkDeviceRepositoryInterface $networkDeviceRepository,
        protected CreateQueueAction $createQueueAction,
        protected UpdateQueueAction $updateQueueAction,
        protected ToggleQueueAction $toggleQueueAction,
        protected DeleteQueueAction $deleteQueueAction,
    ) {}


    /**
     * Resolve network provider for device.
     */
    protected function provider(int $deviceId)
    {
        $device = $this->networkDeviceRepository->findOrFail($deviceId);

        $connected = $this->networkManager->connect($device->id);

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

        $device = $this->networkDeviceRepository->find($deviceId);

        $devices = $this->networkDeviceRepository->active();


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

        $device = $this->networkDeviceRepository->find($deviceId);


        $devices = $this->networkDeviceRepository->active();


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


        $result = $this->createQueueAction->execute(
            (int) $request->device_id,
            $request->name,
            $request->target,
            $request->max_limit,
            $request->limit_at,
            $request->priority ?? 1,
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


        $device = $this->networkDeviceRepository->find($deviceId);


        $devices = $this->networkDeviceRepository->active();



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



        $result = $this->updateQueueAction->execute(
            (int) $request->device_id,
            $name,
            $request->only([
                'max_limit',
                'limit_at',
                'priority',
                'comment',
            ]),
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



        $result = $this->toggleQueueAction->execute(
            $deviceId,
            $name,
            $action,
        );



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



        $result = $this->deleteQueueAction->execute(
            $deviceId,
            $name,
        );



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
