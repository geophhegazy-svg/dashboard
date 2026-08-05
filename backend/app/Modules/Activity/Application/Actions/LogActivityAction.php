<?php

declare(strict_types=1);

namespace App\Modules\Activity\Application\Actions;

use App\Modules\Activity\Infrastructure\Persistence\Models\ActivityLog;
use App\Modules\Activity\Domain\Contracts\ActivityRepositoryInterface;

final readonly class LogActivityAction
{
    public function __construct(
        private ActivityRepositoryInterface $repository,
    ) {}

    public function execute(
        array $attributes,
        array $values = [],
    ): ActivityLog {

        return $this->repository->firstOrCreate(
            $attributes,
            $values,
        );
    }
}
