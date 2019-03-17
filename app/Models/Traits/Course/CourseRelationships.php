<?php

namespace App\Models\Traits\Course;

trait CourseRelationships
{
    /**
     * Get the assignments of this course.
     *
     * @return array
     */
    public function assignments()
    {
        return $this->hasMany('App\Models\Assignment');
    }

    /**
     * Get the enroll records of this course.
     *
     * @return mixed
     */
    public function enrollRecords()
    {
        return $this->hasMany('App\Models\CourseEnrollRecord');
    }
}