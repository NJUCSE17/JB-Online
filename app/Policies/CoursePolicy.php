<?php

namespace App\Policies;

use App\Models\Course;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CoursePolicy
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
     * Determine whether the user can view the course.
     *
     * @return mixed
     */
    public function view()
    {
        return true;
    }

    /**
     * Determine whether the user can create courses.
     *
     * @return mixed
     */
    public function create()
    {
        return false;
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
        return $user->isCourseAdmin($course);
    }

    /**
     * Determine whether the user can delete the course.
     *
     * @return mixed
     */
    public function delete()
    {
        return false;
    }

    /**
     * Determine whether the user can enroll to a course.
     *
     * @return bool
     */
    public function enroll()
    {
        return true;
    }

    /**
     * Determine whether the user can quit from a course.
     *
     * @return bool
     */
    public function quit()
    {
        return true;
    }
}
