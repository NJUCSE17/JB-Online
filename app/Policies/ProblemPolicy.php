<?php

namespace App\Policies;

use App\Models\Problem;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProblemPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the problem.
     *
     * @param  \App\Models\User $user
     * @param  \App\Models\Problem $problem
     * @return mixed
     */
    public function view(User $user, Problem $problem)
    {
        return true;
    }

    /**
     * Determine whether the user can create problems.
     *
     * @param  \App\Models\User $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->privilege_level <= 2;
    }

    /**
     * Determine whether the user can update the problem.
     *
     * @param  \App\Models\User $user
     * @param  \App\Models\Problem $problem
     * @return mixed
     */
    public function update(User $user, Problem $problem)
    {
        return $user->privilege_level <= 2 || $user->isCourseAdmin($problem->course());
    }

    /**
     * Determine whether the user can delete the problem.
     *
     * @param  \App\Models\User $user
     * @param  \App\Models\Problem $problem
     * @return mixed
     */
    public function delete(User $user, Problem $problem)
    {
        return $user->privilege_level <= 2 || $user->isCourseAdmin($problem->course());
    }

    /**
     * Determine whether the user can restore the problem.
     *
     * @param  \App\Models\User $user
     * @param  \App\Models\Problem $problem
     * @return mixed
     */
    public function restore(User $user, Problem $problem)
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the problem.
     *
     * @param  \App\Models\User $user
     * @param  \App\Models\Problem $problem
     * @return mixed
     */
    public function forceDelete(User $user, Problem $problem)
    {
        return false;
    }
}
