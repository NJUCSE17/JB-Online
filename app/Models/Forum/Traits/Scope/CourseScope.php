<?php

namespace App\Models\Forum\Traits\Scope;

/**
 * Class CourseScope.
 */
trait CourseScope
{
    public function scopeSubscribedByUser($query, $userID)
    {
        return $query->join('course_enroll_records', function ($join) use ($userID) {
            $join->where('course_enroll_records.user_id', $userID)
                ->on('courses.id', '=', 'course_enroll_records.course_id');
        });
    }
}