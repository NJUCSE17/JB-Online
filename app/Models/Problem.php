<?php

namespace App\Models;

use App\Models\Traits\Problem\ProblemRelationships;
use Cog\Contracts\Love\Likeable\Models\Likeable as LikeableContract;
use Cog\Laravel\Love\Likeable\Models\Traits\Likeable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Problem extends Model implements LikeableContract
{
    use SoftDeletes,
        Likeable,
        ProblemRelationships;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable
        = [
            'course_id',
            'assignment_id',
            'content',
        ];
}
