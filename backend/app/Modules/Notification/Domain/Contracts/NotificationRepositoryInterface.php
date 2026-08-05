<?php

declare(strict_types=1);

namespace App\Modules\Notification\Domain\Contracts;

use App\Modules\Notification\Infrastructure\Persistence\Models\Notification;
use Illuminate\Database\Eloquent\Collection;

interface NotificationRepositoryInterface
{
    public function all(): Collection;

    public function find(int $id): ?Notification;

    public function save(Notification $notification): bool;

    public function delete(Notification $notification): bool;

    public function firstOrCreate(
        array $attributes,
        array $values = [],
    ): Notification;
}
