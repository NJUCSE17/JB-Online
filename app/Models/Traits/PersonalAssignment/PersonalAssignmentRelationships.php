<?php

namespace App\Models\Traits\PersonalAssignment;

trait PersonalAssignmentRelationships
{
    /**
     * Get the course that this assignment belongs to.
     *
     * @return mixed
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    /**
     * Get the finish records of this assignment.
     *
     * @return mixed
     */
    public function finishRecords()
    {
        return $this->hasMany('App\Models\PersonalAssignmentFinishRecord');
    }
}