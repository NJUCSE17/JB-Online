<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Filter for all polices in this class.
     *
     * @param  User  $user
     *
     * @return mixed
     */
    public function before(User $user)
    {
        if ($user->isActive() && $user->isVerified()) {
            if ($user->privilege_level <= 1) {
                return true;
            } else {
                return null;
            }
        } else {
            return false;
        }
    }

    /**
     * Determine whether the user can view the model.
     *
     * @return mixed
     */
    public function view()
    {
        return true;
    }

    /**
     * Determine whether the user can create models.
     *
     * @return mixed
     */
    public function create()
    {
        return false;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\User  $model
     *
     * @return mixed
     */
    public function update(User $user, User $model)
    {
        return $user->is($model);
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @return mixed
     */
    public function delete()
    {
        return false;
    }

    /**
     * Determine whether the user can activate the model.
     *
     * @return bool
     */
    public function activate()
    {
        return false;
    }

    /**
     * Determine whether the user can deactivate the model.
     *
     * @return bool
     */
    public function deactivate()
    {
        return false;
    }
}
