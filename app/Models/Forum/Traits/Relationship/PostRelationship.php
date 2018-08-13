<?php

namespace App\Models\Forum\Traits\Relationship;

use App\Models\Auth\User;
use App\Models\Forum\Assignment;

/**
 * Class PostRelationship.
 */
trait PostRelationship
{
    /**
     * @return mixed
     */
    public function source()
    {
        return $this->belongsTo(Assignment::class, 'assignment_id');
    }

    /**
     * @return mixed
     */
    public function author()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * @return mixed
     */
    public function editor()
    {
        return $this->belongsTo(User::class, 'editor_id');
    }
}
