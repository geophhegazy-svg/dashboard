<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Network;

use App\Http\Controllers\Controller;
use App\Modules\Network\Application\Actions\CreateFirewallRuleAction;
use App\Modules\Network\Application\Actions\UpdateFirewallRuleAction;
use App\Modules\Network\Application\Actions\DeleteFirewallRuleAction;
use App\Modules\Network\Application\Contracts\NetworkManagerInterface;
use App\Modules\Network\Domain\Contracts\NetworkDeviceRepositoryInterface;
use Illuminate\Http\Request;

class FirewallController extends Controller
{
    public function __construct(
        protected NetworkManagerInterface $networkManager,
        protected NetworkDeviceRepositoryInterface $networkDeviceRepository,
        protected CreateFirewallRuleAction $createFirewallRuleAction,
        protected UpdateFirewallRuleAction $updateFirewallRuleAction,
        protected DeleteFirewallRuleAction $deleteFirewallRuleAction,
    ) {}


    /**
     * Resolve network provider.
     */
    protected function provider(int $deviceId)
    {
        $device = $this->networkDeviceRepository->findOrFail($deviceId);


        if (! $this->networkManager->connect($device->id)) {
            return null;
        }


        return $this->networkManager->provider();
    }



    /**
     * Display firewall rules.
     */
    public function index(Request $request)
    {
        $this->authorize('firewall.view');

        $deviceId = (int) $request->input(
            'device_id',
            1
        );


        $device = $this->networkDeviceRepository->find($deviceId);


        $devices = $this->networkDeviceRepository->active();



        $rules = [];

        $connected = false;



        if ($device) {

            $provider = $this->provider($deviceId);


            if ($provider) {

                $connected = true;


                $rules = $provider
                    ->firewall()
                    ->getRules();
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
        $this->authorize('firewall.create');

        $deviceId = (int) $request->input(
            'device_id',
            1
        );


        $device = $this->networkDeviceRepository->find($deviceId);


        $devices = $this->networkDeviceRepository->active();



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
        $this->authorize('firewall.create');

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



        $result = $this->createFirewallRuleAction->execute(
            (int) $request->device_id,
            $request->only([
                'chain',
                'action',
                'src_address',
                'dst_address',
                'protocol',
                'dst_port',
                'comment',
            ]),
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
        $this->authorize('firewall.update');


        $deviceId = (int) $request->input(
            'device_id',
            1
        );


        $device = $this->networkDeviceRepository->find($deviceId);


        $devices = $this->networkDeviceRepository->active();



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
        $this->authorize('firewall.update');


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



        $result = $this->updateFirewallRuleAction->execute(
            (int) $request->device_id,
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
            ),
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
        $this->authorize('firewall.delete');


        $deviceId = (int) $request->input(
            'device_id',
            1
        );


        $result = $this->deleteFirewallRuleAction->execute(
            $deviceId,
            $id,
        );



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
