<?php

namespace App\Models\Forum\Traits\Method;

use App\Models\Auth\User;
use Illuminate\Support\Facades\Auth;

trait CourseMethod {

    /**
     * Add a user to a course
     *
     * @param User $user
     */
    public function addStudent(User $user)
    {
        /* remove admin and add normal student */
        if ($this->dislikeBy($user)) $this->undislikeBy($user);
        if (!$this->isLikedBy($user)) $this->likeBy($user);
    }

    /**
     * Delete a user from a course.
     *
     * @param User $user
     */
    public function deleteStudent(User $user)
    {
        if ($this->isLikedBy($user)) $this->unlikeBy($user);
    }

    /**
     * Add an admin to a course.
     *
     * @param User $user
     */
    public function addAdmin(User $user)
    {
        /* remove admin and normal student */
        if ($this->likeBy($user)) $this->unlikeBy($user);
        if (!$this->isDislikedBy($user)) $this->dislikeBy($user);
    }

    /**
     * Delete an admin of a course.
     *
     * @param User $user
     */
    public function deleteAdmin(User $user)
    {
        if ($this->isDislikedBy($user)) $this->undislikeBy($user);
    }
}