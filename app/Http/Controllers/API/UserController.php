<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\APIController;
use App\Http\Requests\User\ActivateUserRequest;
use App\Http\Requests\User\ShowUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Http\Requests\User\ViewUserRequest;
use App\Http\Resources\UserResource;
use App\Http\Resources\UserResourceCollection;
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
        if ($request->has('self') && $request->get('self')) {
            $user = \Auth::user();

            return $this->data(new UserResource($user));
        } else {
            $users = User::all();

            return $this->data(new UserResourceCollection($users));
        }
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
        return $this->data(new UserResource($user));
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
        if (\Auth::user()->privilege_level >= 2) {
            // non-admin need to validate password
            if (!$request->has('password')) {
                return $this->error('No password given.', 403);
            } else {
                if (!\Auth::guard('web')->attempt([
                    'student_id' => $user->student_id,
                    'password'   => $request->get('password'),
                ])
                ) {
                    return $this->error('Password check failed.', 403);
                }
            }
        }

        $name = $request->has('name') ? $request->get('name') : $user->name;
        $email = $request->has('email') ? $request->get('email') : $user->email;
        $want_email = $request->has('want_email')
            ? $request->get('want_email') : $user->want_email;
        $blog = $request->has('blog_feed_url')
            ? $request->get('blog_feed_url') : $user->blog_feed_url;
        $pass = $request->has('new_password')
            ? Hash::make($request->get('new_password')) : $user->password;
        if ($email !== $user->email) {
            $user->resetEmail();
            $user->deactivate();
        }
        $user->update(
            [
                'name'          => $name,
                'email'         => $email,
                'want_email'    => $want_email,
                'blog_feed_url' => $blog,
                'password'      => $pass,
            ]
        );

        return $this->data(new UserResource($user));
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

        return $this->data(new UserResource($user));
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

        return $this->data(new UserResource($user));
    }
}
