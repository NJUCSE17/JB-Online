<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\APIController;
use App\Http\Requests\User\ActivateUserRequest;
use App\Http\Requests\User\ShowUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Http\Requests\User\ViewUserRequest;
use App\Http\Resources\UserRecourse;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends APIController
{
    /**
     * List users.
     *
     * @param  ShowUserRequest  $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(ViewUserRequest $request)
    {
        $user = User::all();

        return $this->data(new UserRecourse($user));
    }

    /**
     * Show a user.
     *
     * @param  ShowUserRequest  $request
     * @param  User             $user
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(ShowUserRequest $request, User $user)
    {
        return $this->data(new UserRecourse($user));
    }

    /**
     * Update a user.
     *
     * @param  UpdateUserRequest  $request
     * @param  User               $user
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        $name = $request->has('name') ? $request->get('name') : $user->name;
        $email = $request->has('email') ? $request->get('email') : $user->email;
        $blog = $request->has('blog_feed_url')
            ? $request->get('blog_feed_url') : $user->blog_feed_url;
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
     * @param  User                 $user
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function activate(ActivateUserRequest $request, User $user)
    {
        $user->activate();

        return $this->data(new UserRecourse($user));
    }

    /**
     * Deactivate an user.
     *
     * @param  ActivateUserRequest  $request
     * @param  User                 $user
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function deactivate(ActivateUserRequest $request, User $user)
    {
        $user->deactivate();

        return $this->data(new UserRecourse($user));
    }
}
