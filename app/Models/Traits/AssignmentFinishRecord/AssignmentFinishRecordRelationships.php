<?php

namespace App\Models\Traits\AssignmentFinishRecord;

trait AssignmentFinishRecordRelationships
{
    /**
     * Get the user this record belongs to.
     *
     * @return mixed
     */
    public function user()
    {
        return $this->belongsTo('App\Model\User');
    }

    /**
     * Get the assignment this record belongs to.
     *
     * @return mixed
     */
    public function assignment()
    {
        return $this->belongsTo('App\Model\Assignment');
    }
}