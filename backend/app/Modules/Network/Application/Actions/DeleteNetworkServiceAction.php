<?php

declare(strict_types=1);

namespace App\Modules\Network\Application\Actions;

use App\Modules\Network\Infrastructure\Persistence\Models\NetworkService;

final class DeleteNetworkServiceAction
{
    public function execute(NetworkService $service): void
    {
        $service->delete();
    }
}
