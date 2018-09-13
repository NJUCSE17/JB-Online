<?php

namespace App\Models\Forum\Traits\Relationship;

use App\Models\Auth\User;
use App\Models\Forum\Assignment;
use App\Models\Forum\Post;

/**
 * Class CourseRelationship.
 */
trait CourseRelationship
{
    /**
     * @return mixed
     */
    public function assignments()
    {
        return $this->hasMany(Assignment::class);
    }

    /**
     * @return mixed
     */
    public function assignmentsCount()
    {
        return $this->assignments()->count();
    }

    /**
     * @return mixed
     */
    public function getAssignments()
    {
        return $this->assignments()->with('source')->orderBy('due_time', 'dec')->get();
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
    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    /**
     * @return mixed
     */
    public function postsCount()
    {
            return $this->posts()->count();
    }

}
