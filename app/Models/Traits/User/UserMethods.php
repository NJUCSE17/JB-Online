<?php

namespace App\Models\Traits\User;

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