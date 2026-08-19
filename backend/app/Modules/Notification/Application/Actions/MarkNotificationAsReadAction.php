<?php

declare(strict_types=1);

namespace App\Modules\Notification\Application\Actions;

use App\Modules\Notification\Infrastructure\Persistence\Models\Notification;

final readonly class MarkNotificationAsReadAction
{
    public function execute(
        Notification $notification,
    ): Notification {

        $notification->update([
            'is_read' => true,
        ]);

        return $notification->fresh();
    }
}
