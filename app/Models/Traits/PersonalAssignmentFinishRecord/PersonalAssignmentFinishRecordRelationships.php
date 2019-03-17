<?php

namespace App\Models\Traits\PersonalAssignmentFinishRecord;

trait PersonalAssignmentFinishRecordRelationships
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
    public function personalAssignment()
    {
        return $this->belongsTo('App\Model\PersonalAssignment');
    }
}