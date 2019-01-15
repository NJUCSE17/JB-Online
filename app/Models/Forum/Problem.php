<?php

namespace App\Models\Forum;

use App\Models\Traits\Uuid;
use Cog\Laravel\Love\Likeable\Models\Traits\Likeable;
use Cog\Contracts\Love\Likeable\Models\Likeable as LikeableContract;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Forum\Traits\Attribute\ProblemAttribute;
use App\Models\Forum\Traits\Relationship\ProblemRelationship;

/**
 * Class Problem.
 */
class Problem extends Model implements LikeableContract
{
    use Uuid,
        Likeable,
        SoftDeletes,
        ProblemAttribute,
        ProblemRelationship;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'course_id',
        'assignment_id',
        'permalink',
        'content',
        'difficulty',
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
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

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
