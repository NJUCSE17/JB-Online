<?php

namespace App\Models\Traits\CourseEnrollRecord;

trait CourseEnrollRecordRelationships
{
    /**
     * Get the user that this record belongs to.
     *
     * @return mixed
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    /**
     * Get the course that this record belongs to.
     *
     * @return mixed
     */
    public function course()
    {
        return $this->belongsTo('App\Models\Course');
    }
}