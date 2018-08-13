<?php

namespace App\Models\Forum;

use App\Models\Traits\Uuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Forum\Traits\Attribute\AssignmentAttribute;
use App\Models\Forum\Traits\Relationship\AssignmentRelationship;

/**
 * Class Assignment.
 */
class Assignment extends Model
{
    use Uuid,
        Notifiable,
        SoftDeletes,
        AssignmentAttribute,
        AssignmentRelationship;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'course_id',
        'name',
        'content',
        'due_time',
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
    protected $dates = ['due_time', 'init_date', 'update_date'];

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
