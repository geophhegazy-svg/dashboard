<?php

declare(strict_types=1);

namespace App\Modules\Activity\Infrastructure\Repositories;

use App\Modules\Activity\Infrastructure\Persistence\Models\ActivityLog;
use App\Modules\Activity\Domain\Contracts\ActivityRepositoryInterface;

final class ActivityRepository implements ActivityRepositoryInterface
{
    public function firstOrCreate(
        array $attributes,
        array $values = [],
    ): ActivityLog {

        return ActivityLog::firstOrCreate(
            $attributes,
            $values,
        );
    }


    public function create(
        array $data,
    ): ActivityLog {

        return ActivityLog::create(
            $data,
        );
    }
}
