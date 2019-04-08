<?php

namespace App\Models;

use App\Models\Traits\Course\CourseRelationships;
use App\Models\Traits\Course\CourseScopes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Course extends Model
{
    use SoftDeletes, CourseRelationships, CourseScopes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable
        = [
            'name',
            'semester',
            'start_time',
            'end_time',
            'notice',
            'notice_html',
        ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts
        = [
            'start_time' => 'datetime',
            'end_time'   => 'datetime',
        ];
}
