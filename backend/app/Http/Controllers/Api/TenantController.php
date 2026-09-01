<?php

namespace App\Http\Controllers\Api;

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
    public function store(TenantStoreRequest $request)
    {
        $this->authorize('create', Tenant::class);

        $tenant = Tenant::create($request->validated());
        return new TenantResource($tenant);
    }
    public function show(Tenant $tenant)
    {
        $this->authorize('view', $tenant);

        return new TenantResource($tenant);
    }
    public function update(TenantUpdateRequest $request, Tenant $tenant)
    {
        $this->authorize('update', $tenant);

        $tenant->update($request->validated());
        return new TenantResource($tenant);
    }
    public function destroy(Tenant $tenant)
    {
        $this->authorize('delete', $tenant);

        $tenant->delete();
        return response()->json(['success' => true, 'message' => 'Tenant deleted successfully']);
    }
}
