<?php

namespace App\Models\Traits\User;

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