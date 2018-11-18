<?php

namespace App\Models\Forum\Traits\Relationship;

use App\Models\Forum\Post;
use App\Models\Forum\Course;
use App\Models\Forum\Problem;

/**
 * Class AssignmentRelationship.
 */
trait AssignmentRelationship
{
    /**
     * @return mixed
     */
    public function source()
    {
        return $this->belongsTo(Course::class, 'course_id');
    }

    /**
     * @return mixed
     */
    public function problems()
    {
        return $this->hasMany(Problem::class);
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

    /**
     * @return mixed
     */
    public function getGroupedPosts($sort = 'asc')
    {
        return $this->posts()
            ->with('author')
            ->orderBy('created_at', $sort)
            ->get()
            ->groupBy('parent_id');
    }
}
