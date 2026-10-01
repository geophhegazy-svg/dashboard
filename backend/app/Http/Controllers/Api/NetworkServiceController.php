<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreNetworkServiceRequest;
use App\Http\Requests\UpdateNetworkServiceRequest;
use App\Http\Resources\NetworkServiceResource;
use App\Modules\Network\Application\Actions\CreateNetworkServiceAction;
use App\Modules\Network\Application\Actions\DeleteNetworkServiceAction;
use App\Modules\Network\Application\Actions\ProvisionNetworkServiceAction;
use App\Modules\Network\Application\Actions\UpdateNetworkServiceAction;
use App\Modules\Network\Infrastructure\Persistence\Models\NetworkService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

final class NetworkServiceController extends Controller
{
    public function __construct(
        private readonly CreateNetworkServiceAction $createAction,
        private readonly UpdateNetworkServiceAction $updateAction,
        private readonly DeleteNetworkServiceAction $deleteAction,
        private readonly ProvisionNetworkServiceAction $provisionAction,
    ) {}

    public function index()
    {
        $this->authorize('network_services.view');

        return NetworkServiceResource::collection(
            NetworkService::query()
                ->with([
                    'customer',
                    'area',
                    'package',
                    'networkDevice',
                ])
                ->paginate()
        );
    }

    public function store(
        StoreNetworkServiceRequest $request
    ): NetworkServiceResource {
        $this->authorize('network_services.create');

        $service = $this->createAction->execute(
            $request->validated()
        );

        return new NetworkServiceResource(
            $service->load([
                'customer',
                'area',
                'package',
                'networkDevice',
            ])
        );
    }

    public function show(
        NetworkService $networkService
    ): NetworkServiceResource {
        $this->authorize('network_services.view');

        return new NetworkServiceResource(
            $networkService->load([
                'customer',
                'area',
                'package',
                'networkDevice',
            ])
        );
    }

    public function update(
        UpdateNetworkServiceRequest $request,
        NetworkService $networkService
    ): NetworkServiceResource {
        $this->authorize('network_services.update');

        $service = $this->updateAction->execute(
            $networkService,
            $request->validated()
        );

        return new NetworkServiceResource(
            $service->load([
                'customer',
                'area',
                'package',
                'networkDevice',
            ])
        );
    }

    public function destroy(
        NetworkService $networkService
    ): Response {
        $this->authorize('network_services.delete');

        $this->deleteAction->execute($networkService);

        return response()->noContent();
    }

    public function provision(
        NetworkService $networkService
    ): JsonResponse {
        $this->authorize('network_services.provision');

        $success = $this->provisionAction->execute(
            $networkService
        );

        $networkService->refresh();

        if (!$success) {
            return response()->json([
                'message' => 'Network service provisioning failed.',
                'data' => new NetworkServiceResource($networkService),
            ], 422);
        }

        return response()->json([
            'message' => 'Network service provisioned successfully.',
            'data' => new NetworkServiceResource($networkService),
        ]);
    }
}
