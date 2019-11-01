<?php

namespace App\Http\Controllers\Web;

use App\Helpers\AssignmentMerger;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
    }

    /**
     * Show the welcome page.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function welcome()
    {
        return view('welcome');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function home()
    {
        return view('frontend.home');
    }

    /**
     * Show the user list page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function listUser(Request $request, User $user)
    {
        $users = User::query()
            ->orderBy('id', 'DESC')
            ->paginate(25);
        return view('frontend.user.list')
            ->with('users', $users);
    }

    /**
     * Show the user info page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function showUser(Request $request, User $user)
    {
        return view('frontend.user.index')
            ->with('user', $user);
    }
}
