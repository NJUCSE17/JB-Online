<?php

namespace App\Policies;

use App\Models\Course;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CoursePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the course.
     *
     * @param  \App\Models\User $user
     * @param  \App\Models\Course $course
     * @return mixed
     */
    public function view(User $user, Course $course)
    {
        return true;
    }

    /**
     * Determine whether the user can create courses.
     *
     * @param  \App\Models\User $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->privilege_level <= 2;
    }

    /**
     * Determine whether the user can update the course.
     *
     * @param  \App\Models\User $user
     * @param  \App\Models\Course $course
     * @return mixed
     */
    public function update(User $user, Course $course)
    {
        return $user->privilege_level <= 2 || $user->isCourseAdmin($course);
    }

    /**
     * Determine whether the user can delete the course.
     *
     * @param  \App\Models\User $user
     * @param  \App\Models\Course $course
     * @return mixed
     */
    public function delete(User $user, Course $course)
    {
        return $user->privilege_level <= 2;
    }

    /**
     * Determine whether the user can enroll to a course.
     *
     * @param User $user
     * @param Course $course
     * @return bool
     */
    public function enroll(User $user, Course $course)
    {
        return true;
    }

    /**
     * Determine whether the user can quit from a course.
     *
     * @param User $user
     * @param Course $course
     * @return bool
     */
    public function quit(User $user, Course $course)
    {
        return true;
    }

    /**
     * Determine whether the user can restore the course.
     *
     * @param  \App\Models\User $user
     * @param  \App\Models\Course $course
     * @return mixed
     */
    public function restore(User $user, Course $course)
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the course.
     *
     * @param  \App\Models\User $user
     * @param  \App\Models\Course $course
     * @return mixed
     */
    public function forceDelete(User $user, Course $course)
    {
        return false;
    }
}
