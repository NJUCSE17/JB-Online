<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ActivationController extends Controller
{
    /**
     * Show not activated notice.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function notice()
    {
        if (Auth::user()->isActive()) {
            return response()->redirectTo('/home');
        }

        return view('auth.activate');
    }
}
