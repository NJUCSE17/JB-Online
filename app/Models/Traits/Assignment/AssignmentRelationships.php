<?php

namespace App\Models\Traits\Assignment;

trait AssignmentRelationships
{
    /**
     * Get the course that this assignment belongs to.
     *
     * @return mixed
     */
    public function course()
    {
        return $this->belongsTo('App\Models\Course');
    }

    /**
     * Get the finish records of this assignment.
     *
     * @return mixed
     */
    public function finishRecords()
    {
        return $this->hasMany('App\Models\AssignmentFinishRecord');
    }
}