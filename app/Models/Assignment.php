<?php

namespace App\Models;

use App\Models\Traits\Assignment\AssignmentAttributes;
use App\Models\Traits\Assignment\AssignmentRelationships;
use Cog\Contracts\Love\Likeable\Models\Likeable as LikeableContract;
use Cog\Laravel\Love\Likeable\Models\Traits\Likeable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Assignment extends Model implements LikeableContract
{
    use SoftDeletes,
        Likeable,
        AssignmentAttributes,
        AssignmentRelationships;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable
        = [
            'course_id',
            'name',
            'content',
            'content_html',
            'due_time',
        ];
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts
        = [
            'due_time' => 'datetime',
        ];
}
