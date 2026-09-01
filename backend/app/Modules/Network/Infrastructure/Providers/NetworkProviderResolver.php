<?php

declare(strict_types=1);

namespace App\Modules\Network\Infrastructure\Providers;

use App\Modules\Network\Domain\Contracts\NetworkProviderInterface;
use App\Modules\Network\Domain\Contracts\NetworkProviderResolverInterface;
use App\Modules\Network\Infrastructure\Providers\MikroTik\MikroTikProvider;
use RuntimeException;

final class NetworkProviderResolver implements NetworkProviderResolverInterface
{
    /**
     * Provider map.
     *
     * @var array<string,class-string<NetworkProviderInterface>>
     */
    protected array $providers = [
        'mikrotik' => MikroTikProvider::class,
    ];

    public function resolve(
        string $type
    ): NetworkProviderInterface {
        return $this->resolveByName($type);
    }

    public function resolveByName(
        string $name
    ): NetworkProviderInterface {
        $name = strtolower($name);

        if (!isset($this->providers[$name])) {
            throw new RuntimeException(
                "Unsupported network provider: {$name}"
            );
        }

        return app($this->providers[$name]);
    }

    public function register(
        string $name,
        string $provider
    ): void {
        if (!is_subclass_of(
            $provider,
            NetworkProviderInterface::class
        )) {
            throw new RuntimeException(
                "{$provider} must implement NetworkProviderInterface"
            );
        }

        $this->providers[strtolower($name)] = $provider;
    }

    /**
     * @return array<int,string>
     */
    public function available(): array
    {
        return array_keys($this->providers);
    }
}
