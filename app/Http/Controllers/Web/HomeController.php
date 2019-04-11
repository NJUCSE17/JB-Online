<?php

namespace App\Http\Controllers\Web;

use App\Helpers\AssignmentMerger;
use App\Http\Controllers\Controller;
use App\Models\BlogFeed;
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
            ->with('assignments', Auth::user()->getOngoingAssignments())
            ->with('feeds', BlogFeed::query()
                ->orderBy('published_at', 'DESC')->take(5)
            );
    }
}
