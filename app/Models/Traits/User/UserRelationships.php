<?php

namespace App\Models\Traits\User;

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
     * Get the course enroll records of this user.
     *
     * @return mixed
     */
    public function courseEnrollRecords()
    {
        return $this->hasMany('App\Models\CourseEnrollRecord');
    }
}