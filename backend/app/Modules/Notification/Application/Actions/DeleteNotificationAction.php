<?php

declare(strict_types=1);

namespace App\Modules\Notification\Application\Actions;

use App\Modules\Notification\Infrastructure\Persistence\Models\Notification;

final readonly class DeleteNotificationAction
{
    public function execute(
        Notification $notification,
    ): bool {
        return (bool) $notification->delete();
    }
}
