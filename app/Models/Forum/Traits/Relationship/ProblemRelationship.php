<?php

namespace App\Models\Forum\Traits\Relationship;

use App\Models\Auth\User;
use App\Models\Forum\Assignment;

/**
 * Class ProblemRelationship.
 */
trait ProblemRelationship
{
    /**
     * @return mixed
     */
    public function source()
    {
        return $this->belongsTo(Assignment::class, 'assignment_id');
    }
}
