<?php

namespace App\Models;

use App\Models\Traits\CourseEnrollRecord\CourseEnrollRecordRelationships;
use Illuminate\Database\Eloquent\Model;

class CourseEnrollRecord extends Model
{
    use CourseEnrollRecordRelationships;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'course_id',
        'type_is_admin',
        'created_at',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'created_at' => 'datetime',
    ];
}
