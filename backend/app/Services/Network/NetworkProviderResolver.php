<?php

declare(strict_types=1);

namespace App\Services\Network;

use App\Contracts\Network\NetworkProviderInterface;
use App\Models\NetworkDevice;
use RuntimeException;

class NetworkProviderResolver
{

    /**
     * Provider map.
     *
     * @var array<string,string>
     */
    protected array $providers = [

        'mikrotik' =>
        \App\Services\Network\Providers\MikroTik\MikroTikProvider::class,

    ];



    /**
     * Resolve provider by network device.
     */
    public function resolve(
        NetworkDevice $device
    ): NetworkProviderInterface {

        $type = strtolower(
            $device->type
        );


        if (!isset($this->providers[$type])) {

            throw new RuntimeException(
                "Unsupported network provider: {$type}"
            );
        }


        return app(
            $this->providers[$type]
        );
    }



    /**
     * Resolve provider by name.
     */
    public function resolveByName(
        string $name
    ): NetworkProviderInterface {

        $name = strtolower($name);


        if (!isset($this->providers[$name])) {

            throw new RuntimeException(
                "Unsupported network provider: {$name}"
            );
        }


        return app(
            $this->providers[$name]
        );
    }



    /**
     * Register new provider dynamically.
     */
    public function register(
        string $name,
        string $provider
    ): void {

        if (
            !is_subclass_of(
                $provider,
                NetworkProviderInterface::class
            )
        ) {

            throw new RuntimeException(
                "{$provider} must implement NetworkProviderInterface"
            );
        }


        $this->providers[strtolower($name)] = $provider;
    }



    /**
     * Get available providers.
     *
     * @return array<int,string>
     */
    public function available(): array
    {
        return array_keys(
            $this->providers
        );
    }
}
