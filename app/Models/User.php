<?php

namespace App\Models;

use App\Models\Traits\User\UserAttributes;
use App\Models\Traits\User\UserMethods;
use App\Models\Traits\User\UserRelationships;
use Cog\Contracts\Love\Liker\Models\Liker as LikerContract;
use Cog\Laravel\Love\Liker\Models\Traits\Liker;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
    implements MustVerifyEmail, LikerContract
{
    use SoftDeletes,
        Liker,
        Notifiable,
        UserAttributes,
        UserMethods,
        UserRelationships;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable
        = [
            'student_id',
            'name',
            'email',
            'want_email',
            'password',
            'avatar_type',
            'avatar_upload',
            'avatar_github',
            'blog_feed_url',
            'email_verified_at',
            'activated_at',
        ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden
        = [
            'password',
            'privilege_level',
            'remember_token',
        ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts
        = [
            'email_verified_at' => 'datetime',
            'activated_at'      => 'datetime',
            'last_login_at'     => 'datetime',
        ];
}