<?php

declare(strict_types=1);

namespace App\Modules\Network\Application\Actions;

use App\Modules\Network\Application\Contracts\NetworkManagerInterface;

final class ToggleQueueAction
{
    public function __construct(
        private readonly NetworkManagerInterface $networkManager,
    ) {
    }

    public function execute(
        int $deviceId,
        string $name,
        string $action,
    ): bool {
        if (! $this->networkManager->connect($deviceId)) {
            return false;
        }

        $provider = $this->networkManager->provider();

        if ($provider === null) {
            return false;
        }

        return $action === 'enable'
            ? $provider->queue()->enable($name)
            : $provider->queue()->disable($name);
    }
}
