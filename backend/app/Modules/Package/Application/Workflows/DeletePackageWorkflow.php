<?php

declare(strict_types=1);

namespace App\Modules\Package\Application\Workflows;

use App\Modules\Package\Infrastructure\Persistence\Models\Package;
use App\Modules\Package\Application\Actions\DeletePackageAction;

final readonly class DeletePackageWorkflow
{
    public function __construct(
        private DeletePackageAction $action,
    ) {}

    public function execute(
        Package $package,
    ): bool {

        return $this->action->execute(
            $package,
        );
    }
}
