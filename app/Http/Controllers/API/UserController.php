<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\APIController;
use App\Http\Requests\User\ActivateUserRequest;
use App\Http\Requests\User\DeleteUserRequest;
use App\Http\Requests\User\StoreUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Http\Requests\User\ViewUserRequest;
use App\Http\Resources\UserRecourse;
use App\Models\User;
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
        return $this->created(new UserRecourse($user));
    }

    /**
     * Get info of a user.
     *
     * @param ViewUserRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function view(ViewUserRequest $request)
    {
        $user = $request->has('user_id') ? User::query()->findOrFail($request->get('user_id')) : Auth::getUser();
        return $this->data(new UserRecourse($user));
    }

    /**
     * Update a user.
     *
     * @param UpdateUserRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateUserRequest $request)
    {
        $user = $request->has('user_id') ? User::query()->findOrFail($request->get('user_id')) : Auth::getUser();
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
     * @param DeleteUserRequest $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function delete(DeleteUserRequest $request)
    {
        // TODO: ADMINS CANNOT BE DELETED!
        User::query()->findOrFail($request->get('user_id'))->delete();
        return $this->data('User deleted.');
    }

    /**
     * Activate an user.
     *
     * @param ActivateUserRequest $request
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
     * @param ActivateUserRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function deactivate(ActivateUserRequest $request)
    {
        $user = User::query()->findOrFail($request->get('user_id'));
        $user->deactivate();
        return $this->data(new UserRecourse($user));
    }
}
