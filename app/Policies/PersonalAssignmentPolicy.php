<?php

namespace App\Policies;

use App\Models\PersonalAssignment;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PersonalAssignmentPolicy
{
    use HandlesAuthorization;

    /**
     * Filter for all polices in this class.
     *
     * @param  User  $user
     *
     * @return mixed
     */
    public function before(User $user)
    {
        if ($user->isActive() && $user->isVerified()) {
            return null;
        } else {
            return false;
        }
    }

    /**
     * Determine whether the user can view the personal assignment.
     *
     * @param  \App\Models\User                $user
     * @param  \App\Models\PersonalAssignment  $personalAssignment
     *
     * @return mixed
     */
    public function view(User $user, PersonalAssignment $personalAssignment)
    {
        return $user->privilege_level <= 2
            || $user->is(
                $personalAssignment->user
            );
    }

    /**
     * Determine whether the user can create personal assignments.
     *
     * @return mixed
     */
    public function create()
    {
        return true;
    }

    /**
     * Determine whether the user can update the personal assignment.
     *
     * @param  \App\Models\User                $user
     * @param  \App\Models\PersonalAssignment  $personalAssignment
     *
     * @return mixed
     */
    public function update(User $user, PersonalAssignment $personalAssignment)
    {
        return $user->privilege_level <= 2
            || $user->is(
                $personalAssignment->user
            );
    }

    /**
     * Determine whether the user can delete the personal assignment.
     *
     * @param  \App\Models\User                $user
     * @param  \App\Models\PersonalAssignment  $personalAssignment
     *
     * @return mixed
     */
    public function delete(User $user, PersonalAssignment $personalAssignment)
    {
        return $user->privilege_level <= 2
            || $user->is(
                $personalAssignment->user
            );
    }

    /**
     * Determine whether the user can finish the personal assignment.
     *
     * @param  User                $user
     * @param  PersonalAssignment  $personalAssignment
     *
     * @return bool
     */
    public function finish(User $user, PersonalAssignment $personalAssignment)
    {
        return $user->is($personalAssignment->user);
    }

    /**
     * Determine whether the user can reset the personal assignment.
     *
     * @param  User                $user
     * @param  PersonalAssignment  $personalAssignment
     *
     * @return bool
     */
    public function reset(User $user, PersonalAssignment $personalAssignment)
    {
        return $user->is($personalAssignment->user);
    }
}
