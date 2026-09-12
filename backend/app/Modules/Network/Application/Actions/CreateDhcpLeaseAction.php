<?php

declare(strict_types=1);

namespace App\Modules\Network\Application\Actions;

use App\Modules\Network\Application\Contracts\NetworkManagerInterface;

final class CreateDhcpLeaseAction
{
    public function __construct(
        private readonly NetworkManagerInterface $networkManager,
    ) {
    }

    public function execute(
        int $deviceId,
        string $address,
        string $macAddress,
        ?string $hostname = null,
        array $options = [],
    ): bool {
        if (! $this->networkManager->connect($deviceId)) {
            return false;
        }

        $provider = $this->networkManager->provider();

        if ($provider === null) {
            return false;
        }

        return $provider->dhcp()->create(
            $address,
            $macAddress,
            $hostname,
            $options,
        );
    }
}
