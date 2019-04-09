<?php

namespace App\Observers;

use App\Models\User;

class UserObserver
{
    /**
     * Handle the user "created" event.
     *
     * @param  User  $user
     *
     * @return void
     */
    public function created(User $user)
    {
        //
    }

    /**
     * Handle the user "updated" event.
     *
     * @param  User  $user
     *
     * @return void
     */
    public function updated(User $user)
    {
        //
    }

    /**
     * Handle the user "deleted" event.
     *
     * @param  User  $user
     *
     * @return void
     */
    public function deleted(User $user)
    {
        //
    }

    /**
     * Handle the user "restored" event.
     *
     * @param  User  $user
     *
     * @return void
     */
    public function restored(User $user)
    {
        //
    }

    /**
     * Handle the user "force deleted" event.
     *
     * @param  User  $user
     *
     * @return void
     */
    public function forceDeleted(User $user)
    {
        //
    }
}
