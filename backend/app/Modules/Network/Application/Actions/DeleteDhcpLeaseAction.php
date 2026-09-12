<?php

declare(strict_types=1);

namespace App\Modules\Network\Application\Actions;

use App\Modules\Network\Application\Contracts\NetworkManagerInterface;

final class DeleteDhcpLeaseAction
{
    public function __construct(
        private readonly NetworkManagerInterface $networkManager,
    ) {
    }

    public function execute(
        int $deviceId,
        string $id,
    ): bool {
        if (! $this->networkManager->connect($deviceId)) {
            return false;
        }

        $provider = $this->networkManager->provider();

        if ($provider === null) {
            return false;
        }

        return $provider->dhcp()->delete($id);
    }
}
