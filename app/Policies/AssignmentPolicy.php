<?php

namespace App\Policies;

use App\Models\Assignment;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class AssignmentPolicy
{
    use HandlesAuthorization;

    /**
     * Filter for all polices in this class.
     *
     * @param User $user
     * @return mixed
     */
    public function before(User $user)
    {
        if ($user->isActive() && $user->isVerified()) {
            if ($user->privilege_level <= 2) {
                return true;
            } else {
                return null;
            }
        } else {
            return false;
        }
    }

    /**
     * Determine whether the user can view the assignments.
     *
     * @return mixed
     */
    public function view()
    {
        return true;
    }

    /**
     * Determine whether the user can create assignments.
     *
     * @return mixed
     */
    public function create()
    {
        return false;
    }

    /**
     * Determine whether the user can update the assignment.
     *
     * @param  \App\Models\User $user
     * @param  \App\Models\Assignment $assignment
     * @return mixed
     */
    public function update(User $user, Assignment $assignment)
    {
        return $user->isCourseAdmin($assignment->course);
    }

    /**
     * Determine whether the user can delete the assignment.
     *
     * @param  \App\Models\User $user
     * @param  \App\Models\Assignment $assignment
     * @return mixed
     */
    public function delete(User $user, Assignment $assignment)
    {
        return $user->isCourseAdmin($assignment->course);
    }

    /**
     * Determine whether the user can finish the assignment.
     *
     * @param User $user
     * @param Assignment $assignment
     * @return bool
     */
    public function finish(User $user, Assignment $assignment)
    {
        return $user->isInCourse($assignment->course);
    }

    /**
     * Determine whether the user can reset the assignment.
     *
     * @param User $user
     * @param Assignment $assignment
     * @return bool
     */
    public function reset(User $user, Assignment $assignment)
    {
        return $user->isInCourse($assignment->course);
    }
}
