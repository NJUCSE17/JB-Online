<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable, UserAttributes, UserMethods, UserRelationships, UserScopes;

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
            'blog',
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
            'activated_at' => 'datetime',
            'last_login_at' => 'datetime',
        ];
}

trait UserAttributes
{
    /**
     * Get HTML element of user avatar.
     *
     * @return string
     */
    public function getAvatarImage()
    {
        return "<img style='height: 32px; width: 32px;' src='"
            . $this->getAvatarURL() . "' alt='' />";
    }

    /**
     * Get the URL of avatar.
     *
     * @return string
     */
    public function getAvatarURL()
    {
        switch ($this->avatar_type) {
            case "github":
                {
                    return $this->avatar_github;
                }
            case "upload":
                {
                    return $this->avatar_upload;
                }
            case "gravatar":
            default:
                {
                    return "https://www.gravatar.com/avatar/"
                        . md5( strtolower( trim( $this->email ) ) )
                        . "?d=" . urlencode( "identicon" );
                }
        }
    }
}

trait UserMethods
{
    /**
     * Activate a user.
     */
    public function activate()
    {
        $this->activated_at = now()->timestamp;
        $this->save();
    }

    /**
     * Deactivate a user.
     */
    public function deactivate()
    {
        $this->activated_at = null;
        $this->save();
    }
}

trait UserRelationships
{

}

trait UserScopes
{

}