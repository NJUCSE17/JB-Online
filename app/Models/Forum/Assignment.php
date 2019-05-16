<?php

namespace App\Models\Forum;

use App\Models\Forum\Traits\Scope\AssignmentScope;
use App\Models\Traits\Uuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Forum\Traits\Attribute\AssignmentAttribute;
use App\Models\Forum\Traits\Relationship\AssignmentRelationship;
use App\Models\Forum\Traits\Method\AssignmentMethod;

/**
 * Class Assignment.
 */
class Assignment extends Model
{
    use Uuid,
        SoftDeletes,
        AssignmentAttribute,
        AssignmentRelationship,
        AssignmentMethod,
        AssignmentScope;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'course_id',
        'name',
        'content',
        'content_html',
        'due_time',
        'issuer',
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