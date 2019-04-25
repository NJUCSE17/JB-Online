<?php

namespace App\Models\Forum;

use App\Models\Traits\Uuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Forum\Traits\Attribute\PostAttribute;
use App\Models\Forum\Traits\Relationship\PostRelationship;

/**
 * DO NOT TRY TO UPDATE THIS CODE.
 * IT WILL BE DEPRECATED IN NEW VERSIONS!
 * Class BlogFeed
 * @package App\Models\Forum
 */
class BlogFeed extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'permalink',
        'title',
        'content',
        'author',
        'avatar',
        'date'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [];

    /**
     * @var array
     */
    protected $dates = ['date'];

    /**
     * The dynamic attributes from mutators that should be returned with the user object.
     * @var array
     */
    protected $appends = [];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [];
}
