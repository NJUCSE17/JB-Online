<?php

namespace App\Models;

use App\Models\Traits\PersonalAssignment\PersonalAssignmentRelationships;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PersonalAssignment extends Model
{
    use SoftDeletes, PersonalAssignmentRelationships;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable
        = [
            'user_id',
            'name',
            'content',
            'content_html',
            'due_time',
            'finished_at',
        ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts
        = [
            'due_time'    => 'datetime',
            'finished_at' => 'datetime',
        ];
}
