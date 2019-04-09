<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\APIController;
use App\Http\Requests\User\ActivateUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Http\Requests\User\ViewUserRequest;
use App\Http\Resources\UserRecourse;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends APIController
{

    /**
     * Get info of a user.
     *
     * @param  ViewUserRequest  $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function view(ViewUserRequest $request)
    {
        $user = $request->has('user_id')
            ? User::query()->findOrFail($request->get('user_id'))
            : Auth::user();

        return $this->data(new UserRecourse($user));
    }

    /**
     * Update a user.
     *
     * @param  UpdateUserRequest  $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateUserRequest $request)
    {
        $user = $request->has('user_id')
            ? User::query()->findOrFail($request->get('user_id'))
            : Auth::user();
        // Authorization is checked by request
        $name = $request->has('name') ? $request->get('name') : $user->name;
        $email = $request->has('email') ? $request->get('email') : $user->email;
        $blog = $request->has('blog_feed_url')
            ? $request->get('blog_feed_url') : $user->blog;
        $pass = $request->has('password')
            ? Hash::make($request->get('password')) : $user->password;
        if ($request->has('email')) {
            $user->resetEmail();
            $user->deactivate();
        }
        $user->update(
            [
                'name'          => $name,
                'email'         => $email,
                'blog_feed_url' => $blog,
                'password'      => $pass,
            ]
        );

        return $this->data(new UserRecourse($user));
    }

    /**
     * Activate an user.
     *
     * @param  ActivateUserRequest  $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function activate(ActivateUserRequest $request)
    {
        $user = User::query()->findOrFail($request->get('user_id'));
        $user->activate();

        return $this->data(new UserRecourse($user));
    }

    /**
     * Deactivate an user.
     *
     * @param  ActivateUserRequest  $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function deactivate(ActivateUserRequest $request)
    {
        $user = User::query()->findOrFail($request->get('user_id'));
        $user->deactivate();

        return $this->data(new UserRecourse($user));
    }
}
