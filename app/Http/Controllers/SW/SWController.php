<?php

namespace App\Http\Controllers\SW;

use App\Http\Controllers\APIController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SWController extends APIController
{
    /**
     * @param  Request  $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request)
    {
        $user = $request->user();
        if (!$user) return $this->error('Unauthorized', 401);

        $token = $user->createToken('service-worker');
        return $this->data($token);
    }

    /**
     * Service worker polling handler.
     *
     * @param  Request  $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function poll(Request $request)
    {
        return $this->data("Hello, world!");
    }
}
