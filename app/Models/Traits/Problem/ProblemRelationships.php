<?php

namespace App\Models\Traits\Problem;

trait ProblemRelationships
{
    /**
     * Get the course that this problem belongs to.
     *
     * @return mixed
     */
    public function course()
    {
        return $this->belongsTo('App\Models\Course');
    }

    /**
     * Get the assignment that this problem belongs to.
     *
     * @return mixed
     */
    public function assignment()
    {
        return $this->belongsTo('App\Models\Assignment');
    }
}
