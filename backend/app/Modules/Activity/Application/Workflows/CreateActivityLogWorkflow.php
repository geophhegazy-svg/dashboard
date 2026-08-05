<?php

declare(strict_types=1);

namespace App\Modules\Activity\Application\Workflows;

use App\Modules\Activity\Infrastructure\Persistence\Models\ActivityLog;
use App\Modules\Activity\Application\Actions\CreateActivityLogAction;

final readonly class CreateActivityLogWorkflow
{
    public function __construct(
        private CreateActivityLogAction $action,
    ) {}

    public function execute(
        array $data,
    ): ActivityLog {

        return $this->action->execute(
            $data,
        );
    }
}
