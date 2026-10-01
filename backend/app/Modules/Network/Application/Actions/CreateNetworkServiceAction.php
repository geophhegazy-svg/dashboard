<?php

declare(strict_types=1);

namespace App\Modules\Network\Application\Actions;

use App\Modules\Network\Infrastructure\Persistence\Models\NetworkService;

final class CreateNetworkServiceAction
{
    /**
     * @param array<string, mixed> $data
     */
    public function execute(array $data): NetworkService
    {
        return NetworkService::create($data);
    }
}
