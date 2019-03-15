<?php

namespace App\Http\Controllers\API;

use App\Http\Resources\UserRecourse;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\APIController;

class UserController extends APIController
{
    public function create(Request $request, $user_id)
    {
        //
    }

    public function get($user_id)
    {
        if (!($user = User::find($user_id))) {
            return $this->error('User not found', 404);
        } else {
            return $this->data(new UserRecourse($user));
        }
    }

    public function update(Request $request, $user_id)
    {
        //
    }

    public function delete(Request $request, $user_id)
    {
        //
    }
}
