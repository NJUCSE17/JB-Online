<?php

namespace App\Models\Traits\User;

use App\Models\Course;

trait UserRelationships
{
    /**
     * Get the personal assignments of this user.
     *
     * @return array
     */
    public function personalAssignments()
    {
        return $this->hasMany('App\Models\PersonalAssignment');
    }

    /**
     * Get the courses the user enrolled in.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function courses()
    {
        return Course::query()->whereIn('id', $this->courseIDs())->get();
    }

    /**
     * Get the IDs of the courses the user enrolled in.
     *
     * @return mixed
     */
    public function courseIDs()
    {
        return $this->courseEnrollRecords()->pluck('course_id')->toArray();
    }

    /**
     * Get the course enroll records of this user.
     *
     * @return mixed
     */
    public function courseEnrollRecords()
    {
        return $this->hasMany('App\Models\CourseEnrollRecord');
    }
}