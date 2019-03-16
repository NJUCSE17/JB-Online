<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AssignmentFinishRecord extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'assignment_id',
    ];
    // TODO: WHEN AN ASSIGNMENT IS CHANGED, REVOKE THE RECORD (ISSUE BY KSL)

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'created_at' => 'datetime',
    ];
}
