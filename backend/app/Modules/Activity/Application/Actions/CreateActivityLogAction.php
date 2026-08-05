<?php

declare(strict_types=1);

namespace App\Modules\Activity\Application\Actions;

use App\Modules\Activity\Infrastructure\Persistence\Models\ActivityLog;
use App\Modules\Activity\Domain\Contracts\ActivityRepositoryInterface;

final readonly class CreateActivityLogAction
{
    public function __construct(
        private ActivityRepositoryInterface $repository,
    ) {}

    public function execute(
        array $data,
    ): ActivityLog {

        return $this->repository->create(
            $data,
        );
    }
}
