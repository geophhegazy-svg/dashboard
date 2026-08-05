<?php

declare(strict_types=1);

namespace App\Modules\Activity\Domain\Contracts;

use App\Modules\Activity\Infrastructure\Persistence\Models\ActivityLog;

interface ActivityRepositoryInterface
{
    public function firstOrCreate(
        array $attributes,
        array $values = [],
    ): ActivityLog;

    public function create(
        array $data,
    ): ActivityLog;
}
