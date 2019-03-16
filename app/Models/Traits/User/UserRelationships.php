<?php

namespace App\Models\Traits\User;

trait UserRelationships
{
    /**
     * One-to-many relationship: user->personalAssignments.
     *
     * @return array
     */
    public function personalAssignments()
    {
        return $this->hasMany('App\Models\PersonalAssignment');
    }
}