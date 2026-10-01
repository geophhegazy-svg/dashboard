<?php

declare(strict_types=1);

namespace App\Modules\Network\Application\Actions;

use App\Modules\Network\Infrastructure\Persistence\Models\NetworkService;

final class UpdateNetworkServiceAction
{
    /**
     * @param array<string, mixed> $data
     */
    public function execute(
        NetworkService $service,
        array $data
    ): NetworkService {
        $service->update($data);

        return $service->refresh();
    }
}
