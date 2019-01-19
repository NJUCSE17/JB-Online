<?php

namespace App\Http\Controllers\Frontend\User;

use App\Http\Controllers\Controller;
use Laravel\Passport\Passport;

/**
 * Class AccountController.
 */
class AccountController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('frontend.user.account');
    }
}
