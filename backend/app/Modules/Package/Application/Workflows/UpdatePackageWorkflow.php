<?php

declare(strict_types=1);

namespace App\Modules\Package\Application\Workflows;

use App\Modules\Package\Infrastructure\Persistence\Models\Package;
use App\Modules\Package\Application\Actions\UpdatePackageAction;

final readonly class UpdatePackageWorkflow
{
    public function __construct(
        private UpdatePackageAction $action,
    ) {}

    public function execute(
        Package $package,
        array $data,
    ): Package {

        return $this->action->execute(
            $package,
            $data,
        );
    }
}
