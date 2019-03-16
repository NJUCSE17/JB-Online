<?php

namespace App\Models\Traits\Course;

trait CourseRelationships
{
    /**
     * One-to-many relationship: course->assignments.
     *
     * @return array
     */
    public function assignments()
    {
        return $this->hasMany('App\Models\Assignment');
    }
}