<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\NetworkDeviceResource;
use App\Modules\Network\Domain\Contracts\NetworkDeviceRepositoryInterface;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

final class NetworkDeviceController extends Controller
{
    public function __construct(
        private readonly NetworkDeviceRepositoryInterface $repository,
    ) {}

    public function index(): AnonymousResourceCollection
    {
        $this->authorize('network_services.create');

        return NetworkDeviceResource::collection(
            $this->repository->active()
        );
    }
}
