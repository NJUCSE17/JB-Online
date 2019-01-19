<?php

namespace App\Models\Forum\Traits\Method;

use App\Models\Auth\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

trait CourseMethod {

    /**
     * Check whether a user is a student/admin of the course.
     * 0 for no-enrollment, 1 for student, 2 for admin
     *
     * @param User $user
     * @return int
     */
    public function checkEnrollment(User $user) : int
    {
        $record = DB::table('course_enroll_records')
            ->where('course_id', $this->id)
            ->where('user_id', $user->id)
            ->first();
        if (!$record) return 0;
        else {
            return $record->type_is_admin ? 2 : 1;
        }
    }

    /**
     * Add a user to a course
     *
     * @param User $user
     */
    public function addStudent(User $user)
    {
        /* remove admin and add normal student */
        $this->deleteUser($user);
        DB::table('course_enroll_records')->insert([
            'course_id' => $this->id,
            'user_id'   => $user->id,
            'type_is_admin' => false,
        ]);
    }

    /**
     * Add an admin to a course.
     *
     * @param User $user
     */
    public function addAdmin(User $user)
    {
        /* remove normal student and add admin  */
        $this->deleteUser($user);
        DB::table('course_enroll_records')->insert([
            'course_id' => $this->id,
            'user_id'   => $user->id,
            'type_is_admin' => true,
        ]);
    }

    /**
     * Delete a user from a course.
     *
     * @param User $user
     */
    public function deleteUser(User $user)
    {
        DB::table('course_enroll_records')
            ->where('course_id', $this->id)
            ->where('user_id', $user->id)
            ->delete();
    }
}