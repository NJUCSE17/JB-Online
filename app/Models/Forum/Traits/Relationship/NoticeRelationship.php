<?php

namespace App\Models\Forum\Traits\Relationship;

use App\Models\Auth\User;

/**
 * Class NoticeRelationship.
 */
trait NoticeRelationship
{
    /**
     * @return mixed
     */
    public function author()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
