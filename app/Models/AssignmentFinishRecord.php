<?php

namespace App\Models;

use App\Models\Traits\AssignmentFinishRecord\AssignmentFinishRecordRelationships;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AssignmentFinishRecord extends Model
{
    use SoftDeletes, AssignmentFinishRecordRelationships;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable
        = [
            'user_id',
            'assignment_id',
        ];
    // TODO: WHEN AN ASSIGNMENT IS CHANGED, REVOKE THE RECORD (ISSUE BY KSL)

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts
        = [
            'created_at' => 'datetime',
        ];
}
