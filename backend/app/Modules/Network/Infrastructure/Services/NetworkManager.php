<?php

declare(strict_types=1);

namespace App\Modules\Network\Infrastructure\Services;

use App\Modules\Network\Application\Contracts\NetworkManagerInterface;
use App\Modules\Network\Domain\Contracts\NetworkProviderInterface;
use App\Modules\Network\Domain\Contracts\NetworkProviderResolverInterface;
use App\Modules\Network\Domain\Contracts\NetworkDeviceRepositoryInterface;
use App\Modules\Network\Infrastructure\Persistence\Models\NetworkDevice;
use Illuminate\Support\Facades\Log;

class NetworkManager implements NetworkManagerInterface
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
        protected NetworkProviderResolverInterface $resolver,
        protected NetworkDeviceRepositoryInterface $networkDeviceRepository,
    ) {}



    /**
     * Connect network device.
     */
    public function connect(
        int $deviceId
    ): bool {

        return $this->connectDevice(
            $this->networkDeviceRepository->findOrFail($deviceId)
        );
    }

    /**
     * Connect using transient device credentials.
     *
     * Infrastructure compatibility path used by MikrotikServiceAdapter.
     */
    public function connectWithCredentials(
        string $ip,
        string $username,
        string $password,
        int $port = 8728,
        string $type = 'mikrotik',
    ): bool {

        $device = new NetworkDevice([
            'ip_address' => $ip,
            'username' => $username,
            'password' => $password,
            'type' => $type,
            'port' => $port,
        ]);

        return $this->connectDevice($device);
    }

    private function connectDevice(
        NetworkDevice $device
    ): bool {

        $this->device = $device;

        try {

            $this->provider =
                $this->resolver->resolve($device->type);

            $connected = $this->provider->connect(
                $device->ip_address,
                $device->username,
                $device->password,
                $device->port ?? 8728
            );

            if ($connected) {

                Log::info(
                    'Network device connected',
                    [
                        'device_id' => $device->id,
                        'provider' => $this->provider->name(),
                        'ip' => $device->ip_address,
                    ]
                );
            }

            return $connected;

        } catch (\Throwable $e) {

            Log::error(
                'Network device connection failed',
                [
                    'device_id' => $device->id,
                    'error' => $e->getMessage(),
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
