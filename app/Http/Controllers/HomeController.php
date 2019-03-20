<?php

namespace App\Http\Controllers;

use App\Http\Controllers\API\AssignmentController;
use App\Http\Requests\Assignment\ViewAssignmentRequest;
use App\Models\Assignment;
use App\Models\PersonalAssignment;
use App\Models\User;
use Faker\Factory;
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
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function test(Request $request)
    {
        $user = Factory(User::class)->create();
        Auth::login($user);
        return PersonalAssignment::query()->get();
    }
}
