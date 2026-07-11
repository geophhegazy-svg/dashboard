<?php

declare(strict_types=1);

namespace App\Services\Network;

use App\Contracts\Network\NetworkProviderInterface;
use App\Models\NetworkDevice;
use Illuminate\Support\Facades\Log;

class NetworkManager
{
    /**
     * Current connected device.
     */
    protected ?NetworkDevice $device = null;


    /**
     * Current provider.
     */
    protected ?NetworkProviderInterface $provider = null;



    public function __construct(
        protected NetworkProviderResolver $resolver
    ) {}



    /**
     * Connect network device.
     */
    public function connect(
        NetworkDevice $device
    ): bool {

        $this->device = $device;


        try {

            $this->provider =
                $this->resolver->resolve($device);



            $connected = $this->provider->connect(
                $device->ip_address,
                $device->username,
                decrypt($device->password),
                $device->port ?? 8728
            );



            if ($connected) {

                Log::info(
                    'Network device connected',
                    [
                        'device_id' =>
                        $device->id,

                        'provider' =>
                        $this->provider->name(),

                        'ip' =>
                        $device->ip_address,
                    ]
                );
            }



            return $connected;
        } catch (\Throwable $e) {


            Log::error(
                'Network device connection failed',
                [
                    'device_id' =>
                    $device->id,

                    'error' =>
                    $e->getMessage(),
                ]
            );


            $this->provider = null;


            return false;
        }
    }



    /**
     * Disconnect current device.
     */
    public function disconnect(): void
    {

        if ($this->provider !== null) {

            $this->provider->disconnect();
        }


        $this->provider = null;
        $this->device = null;
    }



    /**
     * Get current provider.
     */
    public function provider(): ?NetworkProviderInterface
    {
        return $this->provider;
    }



    /**
     * Get current device.
     */
    public function device(): ?NetworkDevice
    {
        return $this->device;
    }



    /**
     * Check connection state.
     */
    public function connected(): bool
    {
        return $this->provider !== null
            &&
            $this->provider->isConnected();
    }



    /**
     * Current provider name.
     */
    public function providerName(): ?string
    {
        return $this->provider?->name();
    }



    /**
     * Get provider capabilities.
     *
     * @return array<int,string>
     */
    public function capabilities(): array
    {
        return $this->provider?->capabilities()
            ?? [];
    }
}
