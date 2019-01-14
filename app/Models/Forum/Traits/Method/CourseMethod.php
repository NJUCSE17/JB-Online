<?php

namespace App\Models\Forum\Traits\Method;

use App\Models\Auth\User;
use Illuminate\Support\Facades\DB;

trait CourseMethod {

    /**
     * Add a user to a course
     *
     * @param User $user
     */
    public function addStudent(User $user)
    {
        /* remove admin and add normal student */
        DB::table('course_enroll_records')
            ->where('course_id', $this->id)
            ->where('user_id', $user->id)
            ->where('type_is_admin', true)
            ->delete();
        DB::table('course_enroll_records')->insert([
            'course_id' => $this->id,
            'user_id'   => $user->id,
            'type_is_admin' => false,
        ]);
    }

    /**
     * Delete a user from a course.
     *
     * @param User $user
     */
    public function deleteStudent(User $user)
    {
        DB::table('course_enroll_records')
            ->where('course_id', $this->id)
            ->where('user_id', $user->id)
            ->where('type_is_admin', false)
            ->delete();
    }

    /**
     * Add an admin to a course.
     *
     * @param User $user
     */
    public function addAdmin(User $user)
    {
        /* remove normal student and add admin  */
        DB::table('course_enroll_records')
            ->where('course_id', $this->id)
            ->where('user_id', $user->id)
            ->where('type_is_admin', false)
            ->delete();
        DB::table('course_enroll_records')->insert([
            'course_id' => $this->id,
            'user_id'   => $user->id,
            'type_is_admin' => true,
        ]);
    }

    /**
     * Delete an admin of a course.
     *
     * @param User $user
     */
    public function deleteAdmin(User $user)
    {
        DB::table('course_enroll_records')
            ->where('course_id', $this->id)
            ->where('user_id', $user->id)
            ->where('type_is_admin', true)
            ->delete();
    }
}