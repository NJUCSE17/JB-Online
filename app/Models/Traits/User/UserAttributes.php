<?php

namespace App\Models\Traits\User;

use App\Models\Assignment;
use App\Models\Course;
use App\Models\CourseEnrollRecord;
use App\Models\PersonalAssignment;
use Illuminate\Database\Query\JoinClause;

trait UserAttributes
{
    /**
     * Get ongoing assignments of the user.
     */
    public function getOngoingAssignments()
    {
        $a1 = Assignment::query()
            ->whereIn('course_id', $this->courseIDs())
            ->leftJoin('assignment_finish_records',
                function (JoinClause $join) {
                    $join->on(
                        'assignments.id',
                        '=', 'assignment_finish_records.assignment_id'
                    )->where(
                        'assignment_finish_records.user_id',
                        '=', $this->id
                    )->whereNull('assignment_finish_records.deleted_at');
                })
            ->select(
                [
                    'assignments.*',
                    'assignment_finish_records.created_at as finished_at',
                ]
            )
            ->get();

        $a2 = PersonalAssignment::query()
            ->where('user_id', $this->id)
            ->where('due_time', '>=', now())
            ->get();

        return collect($a1)->merge(collect($a2))
            ->sortBy('due_time');
    }

    /**
     * Check whether user is email-verified.
     *
     * @return bool
     */
    public function isVerified()
    {
        return $this->email_verified_at != null;
    }

    /**
     * Check whether user is activated.
     *
     * @return bool
     */
    public function isActive()
    {
        return $this->activated_at != null;
    }

    /**
     * Get HTML element of user avatar.
     *
     * @return string
     */
    public function getAvatarImage()
    {
        return "<img style='height:36px;width:36px;border-radius:4px;'"
            ." src='".$this->getAvatarURL()."' alt='".$this->name."' />";
    }

    /**
     * Get the URL of avatar.
     *
     * @return string
     */
    public function getAvatarURL()
    {
        switch ($this->avatar_type) {
            case "github":
                {
                    return $this->avatar_github;
                }
            case "upload":
                {
                    return $this->avatar_upload;
                }
            case "gravatar":
            default:
                {
                    return "https://www.gravatar.com/avatar/"
                        .md5(strtolower(trim($this->email)))
                        ."?d=".urlencode("identicon");
                }
        }
    }

    /**
     * Check whether a user is in course.
     *
     * @param  Course  $course
     *
     * @return bool
     */
    public function isInCourse(Course $course)
    {
        return CourseEnrollRecord::query()
            ->where('user_id', $this->id)
            ->where('course_id', $course->id)
            ->exists();
    }

    /**
     * Check whether a user is admin of a course.
     *
     * @param  Course  $course
     *
     * @return bool
     */
    public function isCourseAdmin(Course $course)
    {
        if ($this->privilege_level <= 2) {
            return true;
        }

        return CourseEnrollRecord::query()
            ->where('user_id', $this->id)
            ->where('course_id', $course->id)
            ->where('type_is_admin', true)
            ->exists();
    }
}