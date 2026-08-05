<?php

declare(strict_types=1);

namespace App\Modules\Notification\Infrastructure\Repositories;

use App\Modules\Notification\Infrastructure\Persistence\Models\Notification;
use Illuminate\Database\Eloquent\Collection;
use App\Modules\Notification\Domain\Contracts\NotificationRepositoryInterface;

final class NotificationRepository implements NotificationRepositoryInterface
{
    public function all(): Collection
    {
        return Notification::all();
    }

    public function find(int $id): ?Notification
    {
        return Notification::find($id);
    }

    public function save(Notification $notification): bool
    {
        return $notification->save();
    }

    public function delete(Notification $notification): bool
    {
        return (bool) $notification->delete();
    }

    public function firstOrCreate(
        array $attributes,
        array $values = [],
    ): Notification {

        return Notification::firstOrCreate(
            $attributes,
            $values,
        );
    }
}
