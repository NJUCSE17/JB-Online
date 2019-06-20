<?php

namespace App\Http\Controllers\SW;

use App\Http\Controllers\APIController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SWController extends APIController
{
    /**
     * @param  Request  $request
     */
    public function register(Request $request)
    {
        $user = Auth::user();
    }
}
