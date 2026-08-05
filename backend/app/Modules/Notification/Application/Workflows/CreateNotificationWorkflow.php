<?php

declare(strict_types=1);

namespace App\Modules\Notification\Application\Workflows;

use App\Modules\Notification\Infrastructure\Persistence\Models\Notification;
use App\Modules\Notification\Application\Actions\CreateNotificationAction;

final readonly class CreateNotificationWorkflow
{
    public function __construct(
        private CreateNotificationAction $action,
    ) {}

    public function execute(
        array $data,
    ): Notification {

        return $this->action->execute(
            new Notification($data),
        );
    }
}
