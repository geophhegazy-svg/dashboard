<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Modules\Network\Domain\Contracts\NetworkProviderInterface;
use App\Modules\Network\Application\Contracts\NetworkManagerInterface;
use App\Modules\Network\Domain\Contracts\NetworkDeviceRepositoryInterface;

class MikrotikController extends Controller
{
    public function __construct(
        protected NetworkManagerInterface $networkManager,
        protected NetworkDeviceRepositoryInterface $networkDeviceRepository,
    ) {}



    /**
     * Health Check
     */
    public function test()
    {
        $this->authorize('mikrotik.view');

        try {

            $deviceId = request()->input('device_id', 1);

            $provider = $this->provider($deviceId);


            if (!$provider) {

                return response()->json([
                    'success' => false,
                    'message' => 'Unable to connect',
                ], 503);
            }


            return response()->json([
                'success' => true,
                'message' => 'Connected successfully',
            ]);
        } catch (\Throwable $e) {

            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 503);
        }
    }



    protected function provider(int $deviceId): ?NetworkProviderInterface
    {
        $device = $this->networkDeviceRepository->find($deviceId);


        if (!$device) {
            return null;
        }


        if (!$this->networkManager->connect($device->id)) {
            return null;
        }


        return $this->networkManager->provider();
    }




    /**
     * PPPoE Users
     */
    public function pppoeUsers()
    {
        $this->authorize('mikrotik.pppoe.view');

        $provider = $this->provider(
            request()->input('device_id', 1)
        );


        if (!$provider) {
            return response()->json([]);
        }


        return response()->json(
            $provider->pppoe()->getAllUsers()
        );
    }




    /**
     * Hotspot Users
     */
    public function hotspotUsers()
    {
        $this->authorize('mikrotik.hotspot.view');

        $provider = $this->provider(
            request()->input('device_id', 1)
        );


        if (!$provider) {
            return response()->json([]);
        }


        return response()->json(
            $provider->hotspot()->getUsers()
        );
    }





   /**
     * Dashboard
     */

}
