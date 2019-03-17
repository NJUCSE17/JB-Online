<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PersonalAssignment extends Model
{
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