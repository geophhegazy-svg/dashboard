<?php

declare(strict_types=1);

namespace App\Modules\Activity\Application\Workflows;

use App\Modules\Activity\Infrastructure\Persistence\Models\ActivityLog;
use App\Modules\Activity\Application\Actions\LogActivityAction;

final readonly class LogActivityWorkflow
{
    public function __construct(
        private LogActivityAction $action,
    ) {}

    public function execute(
        array $attributes,
        array $values = [],
    ): ActivityLog {

        return $this->action->execute(
            $attributes,
            $values,
        );
    }
}
