<?php

namespace App\Http\Controllers\Api;

use App\Models\Package;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\StorePackageRequest;
use App\Http\Resources\PackageResource;

class PackageController extends Controller
{
    public function index()
    {
        return PackageResource::collection(
            Package::latest()->paginate()
        );
    }

    public function store(StorePackageRequest $request)
    {
        $package = Package::create(
            $request->validated()
        );

        return new PackageResource($package);
    }

    public function show(Package $package)
    {
        return new PackageResource($package);
    }

    public function update(StorePackageRequest $request, Package $package)
    {
        $package->update(
            $request->validated()
        );

        return new PackageResource($package);
    }

    public function destroy(Package $package)
    {
        $package->delete();

        return response()->json([
            'message' => 'Package deleted successfully'
        ]);
    }
}
