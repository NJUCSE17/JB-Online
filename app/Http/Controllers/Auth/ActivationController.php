<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ActivationController extends Controller
{
    /**
     * Show not activated notice.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function notice(Request $request)
    {
        if ($request->user()->isActive()) {
            return response()->redirectTo(route('home'));
        }

        return view('auth.activate');
    }
}
