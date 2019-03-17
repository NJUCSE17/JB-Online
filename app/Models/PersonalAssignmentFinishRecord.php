<?php

namespace App\Models;

use App\Models\Traits\PersonalAssignmentFinishRecord\PersonalAssignmentFinishRecordRelationships;
use Illuminate\Database\Eloquent\Model;

class PersonalAssignmentFinishRecord extends Model
{
    use PersonalAssignmentFinishRecordRelationships;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'personal_assignment_id',
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
