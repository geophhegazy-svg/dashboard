<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePackageRequest;
use App\Http\Resources\PackageResource;
use App\Modules\Package\Infrastructure\Persistence\Models\Package;
use App\Modules\Package\Domain\Contracts\PackageRepositoryInterface;
use App\Modules\Package\Application\Actions\CreatePackageAction;
use App\Modules\Package\Application\Actions\UpdatePackageAction;
use App\Modules\Package\Application\Actions\DeletePackageAction;

final class PackageController extends Controller
{
    public function __construct(
        private readonly PackageRepositoryInterface $repository,
        private readonly CreatePackageAction $createAction,
        private readonly UpdatePackageAction $updateAction,
        private readonly DeletePackageAction $deleteAction,
    ) {}

    public function index()
    {
        $this->authorize('viewAny', Package::class);

        return PackageResource::collection(
            $this->repository->paginate()
        );
    }

    public function store(StorePackageRequest $request): PackageResource
    {
        $this->authorize('create', Package::class);

        $package = $this->createAction->execute(
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

        $package = $this->updateAction->execute(
            $package,
            $request->validated()
        );

        return new PackageResource($package);
    }

    public function destroy(
        Package $package,
    ) {
        $this->authorize('delete', $package);

        $this->deleteAction->execute($package);

        return response()->noContent();
    }
}
