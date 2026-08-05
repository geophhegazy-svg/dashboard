<?php

declare(strict_types=1);

namespace App\Modules\Package\Application\Workflows;

use App\Modules\Package\Infrastructure\Persistence\Models\Package;
use App\Modules\Package\Application\Actions\CreatePackageAction;

final readonly class CreatePackageWorkflow
{
    public function __construct(
        private CreatePackageAction $action,
    ) {}

    public function execute(
        array $data,
    ): Package {

        return $this->action->execute(
            $data,
        );
    }
}
