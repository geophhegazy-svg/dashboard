<?php

declare(strict_types=1);

namespace App\Modules\Notification\Application\Actions;

use App\Modules\Notification\Infrastructure\Persistence\Models\Notification;
use App\Modules\Notification\Domain\Contracts\NotificationRepositoryInterface;

final readonly class CreateNotificationAction
{
    public function __construct(
        private NotificationRepositoryInterface $repository,
    ) {}

    public function execute(
        Notification $notification,
    ): Notification {

        $this->repository->save(
            $notification,
        );

        return $notification;
    }
}
