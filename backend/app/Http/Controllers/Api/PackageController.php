<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePackageRequest;
use App\Http\Resources\PackageResource;
use App\Models\Package;
use App\Services\Package\PackageService;
use Illuminate\Http\JsonResponse;

class PackageController extends Controller
{
    public function __construct(
        private readonly PackageService $packageService
    ) {}

    public function index()
    {
        return PackageResource::collection(
            $this->packageService->paginate()
        );
    }

    public function store(
        StorePackageRequest $request
    ): PackageResource {
        return new PackageResource(
            $this->packageService->create(
                $request->validated()
            )
        );
    }

    public function show(
        Package $package
    ): PackageResource {
        return new PackageResource($package);
    }

    public function update(
        StorePackageRequest $request,
        Package $package
    ): PackageResource {
        return new PackageResource(
            $this->packageService->update(
                $package,
                $request->validated()
            )
        );
    }

    public function destroy(
        Package $package
    ): JsonResponse {
        $this->packageService->delete($package);

        return response()->json([
            'message' => 'Package deleted successfully',
        ]);
    }
}
