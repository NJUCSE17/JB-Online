<?php

namespace App\Models;

use App\Models\Traits\Problem\ProblemRelationships;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Problem extends Model
{
    use SoftDeletes, ProblemRelationships;

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
