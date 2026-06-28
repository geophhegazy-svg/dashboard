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
        return TenantResource::collection(Tenant::latest()->paginate(15));
    }
    public function store(TenantStoreRequest $request)
    {
        $tenant = Tenant::create($request->validated());
        return new TenantResource($tenant);
    }
    public function show(Tenant $tenant)
    {
        return new TenantResource($tenant);
    }
    public function update(TenantUpdateRequest $request, Tenant $tenant)
    {
        $tenant->update($request->validated());
        return new TenantResource($tenant);
    }
    public function destroy(Tenant $tenant)
    {
        $tenant->delete();
        return response()->json(['success' => true, 'message' => 'Tenant deleted successfully']);
    }
}
