<?php

namespace App\Http\Controllers\Api;

use App\Application\Actions\Tenant\CreateTenantAction;
use App\Application\Actions\Tenant\DeleteTenantAction;
use App\Application\Actions\Tenant\UpdateTenantAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\TenantStoreRequest;
use App\Http\Requests\TenantUpdateRequest;
use App\Http\Resources\TenantResource;
use App\Models\Tenant;

class TenantController extends Controller
{
    public function index()
    {
        $this->authorize('viewAny', Tenant::class);

        return TenantResource::collection(Tenant::latest()->paginate(15));
    }

    public function store(
        TenantStoreRequest $request,
        CreateTenantAction $action,
    ) {
        $this->authorize('create', Tenant::class);

        $tenant = $action->execute($request->validated());

        return new TenantResource($tenant);
    }

    public function show(Tenant $tenant)
    {
        $this->authorize('view', $tenant);

        return new TenantResource($tenant);
    }

    public function update(
        TenantUpdateRequest $request,
        Tenant $tenant,
        UpdateTenantAction $action,
    ) {
        $this->authorize('update', $tenant);

        $tenant = $action->execute(
            $tenant,
            $request->validated(),
        );

        return new TenantResource($tenant);
    }

    public function destroy(
        Tenant $tenant,
        DeleteTenantAction $action,
    ) {
        $this->authorize('delete', $tenant);

        $action->execute($tenant);

        return response()->json([
            'success' => true,
            'message' => 'Tenant deleted successfully',
        ]);
    }
}
