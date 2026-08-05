<?php

declare(strict_types=1);

namespace App\Modules\Notification\Application\Workflows;

use App\Modules\Notification\Infrastructure\Persistence\Models\Notification;
use App\Modules\Notification\Application\Actions\CreateReminderAction;
use App\Modules\Subscription\Infrastructure\Persistence\Models\Subscription;

final readonly class CreateReminderWorkflow
{
    public function __construct(
        private CreateReminderAction $action,
    ) {}

    public function execute(
        Subscription $subscription,
        int $days,
    ): Notification {

        return $this->action->execute(
            $subscription,
            $days,
        );
    }
}
