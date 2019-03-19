<?php

namespace App\Models;

use App\Models\Traits\Problem\ProblemRelationships;
use Illuminate\Database\Eloquent\Model;

class Problem extends Model
{
    use ProblemRelationships;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'course_id',
        'assignment_id',
        'content',
    ];
}
