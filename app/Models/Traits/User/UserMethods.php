<?php

namespace App\Models\Traits\User;

trait UserMethods
{
    /**
     * Reset Email Verification
     */
    public function resetEmail()
    {
        if (!$this->isVerified()) return;
        $this->email_verified_at = null;
        $this->save();
    }

    /**
     * Activate a user.
     */
    public function activate()
    {
        if ($this->isActive()) return;
        $this->activated_at = now()->timestamp;
        $this->save();
    }

    /**
     * Deactivate a user.
     */
    public function deactivate()
    {
        if (!$this->isActive()) return;
        $this->activated_at = null;
        $this->save();
    }
}