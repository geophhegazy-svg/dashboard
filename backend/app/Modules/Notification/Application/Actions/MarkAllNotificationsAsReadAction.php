<?php

declare(strict_types=1);

namespace App\Modules\Notification\Application\Actions;

use App\Modules\Notification\Infrastructure\Persistence\Models\Notification;

final readonly class MarkAllNotificationsAsReadAction
{
    public function execute(): int
    {
        return Notification::query()
            ->where('is_read', false)
            ->update([
                'is_read' => true,
            ]);
    }
}
