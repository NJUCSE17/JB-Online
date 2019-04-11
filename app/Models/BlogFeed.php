<?php

namespace App\Models;

use App\Models\Traits\BlogFeed\BlogFeedAttributes;
use App\Models\Traits\BlogFeed\BlogFeedRelationship;
use Illuminate\Database\Eloquent\Model;

class BlogFeed extends Model
{
    use BlogFeedAttributes,
        BlogFeedRelationship;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable
        = [
            'user_id',
            'user_name',
            'permalink',
            'title',
            'content_html',
            'published_at',
        ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts
        = [
            'published_at' => 'datetime',
        ];
}
