<?php

namespace App\Policies;

use App\Models\Problem;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProblemPolicy
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
     * Determine whether the user can view the problem.
     *
     * @return mixed
     */
    public function view()
    {
        return true;
    }

    /**
     * Determine whether the user can create problems.
     *
     * @return mixed
     */
    public function create()
    {
        return false;
    }

    /**
     * Determine whether the user can update the problem.
     *
     * @param  \App\Models\User     $user
     * @param  \App\Models\Problem  $problem
     *
     * @return mixed
     */
    public function update(User $user, Problem $problem)
    {
        return $user->isCourseAdmin($problem->course);
    }

    /**
     * Determine whether the user can delete the problem.
     *
     * @param  \App\Models\User     $user
     * @param  \App\Models\Problem  $problem
     *
     * @return mixed
     */
    public function delete(User $user, Problem $problem)
    {
        return $user->isCourseAdmin($problem->course);
    }
}
