<?php

namespace App\Policies;

use App\Models\ActivityLog;
use App\Models\User;
use App\Policies\Concerns\AuthorizesByPermission;

class ActivityLogPolicy
{
    use AuthorizesByPermission;
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $this->can($user, 'activity-logs.viewAny');
        return false;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, ActivityLog $activityLog): bool
    {
        return $this->can($user, 'activity-logs.view');
        return false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $this->can($user, 'activity-logs.create');
        return false;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, ActivityLog $activityLog): bool
    {
        return $this->can($user, 'activity-logs.update');
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, ActivityLog $activityLog): bool
    {
        return $this->can($user, 'activity-logs.delete');
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, ActivityLog $activityLog): bool
    {
        return $this->can($user, 'activity-logs.restore');
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, ActivityLog $activityLog): bool
    {
        return $this->can($user, 'activity-logs.forceDelete');
        return false;
    }
}
