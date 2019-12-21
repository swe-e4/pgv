<?php

namespace App\Policies;

use App\Milestone;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class MilestonePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any milestones.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return in_array($user->role_id, [1, 2]);
    }

    /**
     * Determine whether the user can view the milestone.
     *
     * @param  \App\User  $user
     * @param  \App\Milestone  $milestone
     * @return mixed
     */
    public function view(User $user, Milestone $milestone)
    {
        return in_array($user->role_id, [1, 2]);
    }

    /**
     * Determine whether the user can create milestones.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->role_id == 1;
    }

    /**
     * Determine whether the user can update the milestone.
     *
     * @param  \App\User  $user
     * @param  \App\Milestone  $milestone
     * @return mixed
     */
    public function update(User $user, Milestone $milestone)
    {
        return $user->role_id == 1;
    }

    /**
     * Determine whether the user can delete the milestone.
     *
     * @param  \App\User  $user
     * @param  \App\Milestone  $milestone
     * @return mixed
     */
    public function delete(User $user, Milestone $milestone)
    {
        return $user->role_id == 1;
    }

    /**
     * Determine whether the user can restore the milestone.
     *
     * @param  \App\User  $user
     * @param  \App\Milestone  $milestone
     * @return mixed
     */
    public function restore(User $user, Milestone $milestone)
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the milestone.
     *
     * @param  \App\User  $user
     * @param  \App\Milestone  $milestone
     * @return mixed
     */
    public function forceDelete(User $user, Milestone $milestone)
    {
        return false;
    }
}
