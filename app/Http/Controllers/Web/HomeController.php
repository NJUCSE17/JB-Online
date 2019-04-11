<?php

namespace App\Http\Controllers;

use App\Helpers\AssignmentMerger;
use App\Models\Assignment;
use App\Models\PersonalAssignment;
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
        $publicAssignments = Assignment::query()
            ->whereIn('course_id', Auth::user()->courseIDs())
            ->where('due_time', '>=', now())
            ->get();
        $privateAssignments = PersonalAssignment::query()
            ->where('user_id', Auth::id())
            ->where('due_time', '>=', now())
            ->get();
        $assignments = AssignmentMerger::mergeAssignments($publicAssignments,
            $privateAssignments);

        return view('home')
            ->with('assignments', $assignments);
    }
}
