<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePackageRequest;
use App\Http\Resources\PackageResource;
use App\Models\Package;
use App\Modules\Package\Application\Services\PackageService;

final class PackageController extends Controller
{
    public function __construct(
        private readonly PackageService $packageService,
    ) {}

    public function index()
    {
        $this->authorize('viewAny', Package::class);

        return PackageResource::collection(
            $this->packageService->paginate()
        );
    }

    public function store(StorePackageRequest $request): PackageResource
    {
        $this->authorize('create', Package::class);

        $package = $this->packageService->create(
            $request->validated()
        );

        return new PackageResource($package);
    }

    public function show(
        Package $package,
    ): PackageResource {

        $this->authorize('view', $package);

        return new PackageResource($package);
    }

    public function update(
        StorePackageRequest $request,
        Package $package,
    ): PackageResource {

        $this->authorize('update', $package);

        $package = $this->packageService->update(
            $package,
            $request->validated()
        );

        return new PackageResource($package);
    }

    public function destroy(
        Package $package,
    ) {

        $this->authorize('delete', $package);

        $this->packageService->delete($package);

        return response()->noContent();
    }
}
