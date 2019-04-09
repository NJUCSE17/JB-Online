<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;

class ActivationController extends Controller
{
    /**
     * Show not activated notice.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function notice()
    {
        return view('auth.activate');
    }
}
