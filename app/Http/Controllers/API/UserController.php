<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\User\StoreUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Http\Resources\UserRecourse;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\APIController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends APIController
{
    /**
     * Create a user.
     *
     * @param StoreUserRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function create(StoreUserRequest $request)
    {
        $data = $request->only(['student_id', 'name', 'email', 'blog', 'password']);
        $user = User::query()->create([
            'student_id' => $data['student_id'],
            'name'       => $data['name'],
            'email'      => $data['email'],
            'blog'       => $data['blog'],
            'password'   => Hash::make($data['password']),
        ]);
        // TODO: FIRE USER CREATED EVENT.
        return $this->data(new UserRecourse($user));
    }

    /**
     * Get info of a user.
     *
     * @param $user_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function get($user_id = null)
    {
        $user = $user_id ? User::query()->findOrFail($user_id) : Auth::getUser();
        return $this->data(new UserRecourse($user));
    }

    /**
     * Update a user.
     *
     * @param UpdateUserRequest $request
     * @param null $user_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateUserRequest $request, $user_id = null)
    {
        $user = $user_id ? User::query()->findOrFail($user_id) : Auth::getUser();
        // Authorization is checked by request
        $name  = $request->has('name')     ? $request->get('name')                 : $user->name;
        $email = $request->has('email')    ? $request->get('email')                : $user->email;
        $blog  = $request->has('blog')     ? $request->get('blog')                 : $user->blog;
        $pass  = $request->has('password') ? Hash::make($request->get('password')) : $user->password;
        if ($request->has('email')) {
            $user->resetEmail();
            $user->deactivate();
        }
        $user->update([
            'name'     => $name,
            'email'    => $email,
            'blog'     => $blog,
            'password' => $pass,
        ]);
        // TODO: FIRE USER UPDATED EVENT
        return $this->data(new UserRecourse($user));
    }

    /**
     * Delete an user.
     *
     * @param Request $request
     * @param $user_id
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function delete(Request $request, $user_id)
    {
        // TODO: ADMINS CANNOT BE DELETED!
        User::query()->findOrFail($user_id)->delete();
        return $this->data('User deleted.');
    }

    /**
     * Activate an user.
     *
     * @param $user_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function activate($user_id)
    {
        $user = User::query()->findOrFail($user_id);
        $user->activate();
        return $this->data(new UserRecourse($user));
    }

    /**
     * Deactivate an user.
     *
     * @param $user_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function deactivate($user_id)
    {
        $user = User::query()->findOrFail($user_id);
        $user->deactivate();
        return $this->data(new UserRecourse($user));
    }
}
