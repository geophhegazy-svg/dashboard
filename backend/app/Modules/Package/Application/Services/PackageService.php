<?php

declare(strict_types=1);

namespace App\Modules\Package\Application\Services;

use App\Modules\Package\Infrastructure\Persistence\Models\Package;
use App\Modules\Package\Domain\Contracts\PackageRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use App\Modules\Package\Application\Actions\CreatePackageAction;
use App\Modules\Package\Application\Actions\UpdatePackageAction;
use App\Modules\Package\Application\Actions\DeletePackageAction;



class PackageService
{
    public function __construct(
        private readonly PackageRepositoryInterface $repository,

        private readonly CreatePackageAction $createWorkflow,
        private readonly UpdatePackageAction $updateWorkflow,
        private readonly DeletePackageAction $deleteWorkflow,
    ) {}

    public function paginate(): LengthAwarePaginator
    {
        return $this->repository->paginate();
    }

    public function create(array $data): Package
    {
        return $this->createWorkflow->execute($data);
    }

    public function update(
        Package $package,
        array $data
    ): Package {

        return $this->updateWorkflow->execute(
            $package,
            $data
        );
    }

    public function delete(
        Package $package,
    ): void {

        $this->deleteWorkflow->execute($package);
    }
}
