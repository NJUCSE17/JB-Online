<?php

namespace App\Models\Traits\BlogFeed;

trait BlogFeedRelationship
{
    /**
     * Get the user of the blog post.
     *
     * @return mixed
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
}