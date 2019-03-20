<?php

namespace App\Models;

use App\Models\Traits\PersonalAssignment\PersonalAssignmentRelationships;
use App\Models\Traits\PersonalAssignment\WithPersonalAssignmentFinishRecordScope;
use Illuminate\Database\Eloquent\Model;

class PersonalAssignment extends Model
{
    use PersonalAssignmentRelationships;

    /**
     * The "booting" method of the model.
     */
    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope(new WithPersonalAssignmentFinishRecordScope);
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'name',
        'content',
        'content_html',
        'due_time',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'due_time' => 'datetime',
    ];
}
