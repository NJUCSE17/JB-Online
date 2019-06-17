<?php

namespace App\Http\Controllers\Web;

use App\Helpers\AssignmentMerger;
use App\Http\Controllers\Controller;
use App\Models\BlogFeed;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        return view('home.home')
            ->with('feeds', BlogFeed::query()
                ->orderBy('published_at', 'DESC')
                ->take(5)->get()
            );
    }

    /**
     * Show the user info page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function user(Request $request, $student_id)
    {
        $user = User::query()
            ->where('student_id', '=', $student_id)
            ->firstOrFail();
        $feeds = BlogFeed::query()
            ->where('user_id', $user->id)
            ->orderBy('published_at', 'desc')
            ->limit(10)->get();

        return view('user.index')
            ->with('user', $user)
            ->with('feeds', $feeds);
    }
}
