<?php

namespace App\Models\Forum;

use App\Models\Traits\Uuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Forum\Traits\Attribute\CourseAttribute;
use App\Models\Forum\Traits\Relationship\CourseRelationship;

/**
 * Class Course.
 */
class Course extends Model
{
    use Uuid,
        Notifiable,
        SoftDeletes,
        CourseAttribute,
        CourseRelationship;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'semester',
        'start_time',
        'end_time',
        'notice',
        'difficulty',
        'restrict_level',
        'user_id',
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
    protected $dates = ['start_time', 'end_time', 'deleted_at'];

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
