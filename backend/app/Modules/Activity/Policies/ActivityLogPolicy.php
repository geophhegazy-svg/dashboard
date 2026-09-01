<?php

declare(strict_types=1);

namespace App\Modules\Activity\Policies;

use App\Core\Security\Authorization\BasePolicy;
use App\Models\User;
use App\Modules\Activity\Infrastructure\Persistence\Models\ActivityLog;

final class ActivityLogPolicy extends BasePolicy
{
    public function viewAny(User $user): bool
    {
        return $this->allow($user, 'activity.view');
    }

    public function view(User $user, ActivityLog $activityLog): bool
    {
        return $this->allow($user, 'activity.view');
    }
}
