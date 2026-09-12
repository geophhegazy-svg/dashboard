<?php

declare(strict_types=1);

namespace App\Modules\Network\Application\Actions;

use App\Modules\Network\Application\Contracts\NetworkManagerInterface;

final class CreateQueueAction
{
    public function __construct(
        private readonly NetworkManagerInterface $networkManager,
    ) {
    }

    public function execute(
        int $deviceId,
        string $name,
        string $target,
        string $maxLimit,
        ?string $limitAt = null,
        int $priority = 1,
        array $options = [],
    ): bool {
        if (! $this->networkManager->connect($deviceId)) {
            return false;
        }

        $provider = $this->networkManager->provider();

        if ($provider === null) {
            return false;
        }

        return $provider->queue()->create(
            $name,
            $target,
            $maxLimit,
            $limitAt,
            $priority,
            $options,
        );
    }
}
