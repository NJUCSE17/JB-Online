<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Repositories\Frontend\Forum\AssignmentRepository;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;

class UserController extends Controller
{
    /**
     * @var AssignmentRepository
     */
    protected $assignmentRepository;

    /**
     * AssignmentController & CourseController constructor.
     *
     * @param AssignmentRepository $assignmentRepository
     */
    public function __construct(AssignmentRepository $assignmentRepository)
    {
        $this->assignmentRepository = $assignmentRepository;
    }

    /**
     * login api
     *
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request){
        if(Auth::attempt(['student_id' => $request->student_id, 'password' => $request->password])){
            $user = Auth::user();
            $success['token'] =  $user->createToken('LaraPassport')->accessToken;
            return response()->json([
                'status' => 'success',
                'data' => $success
            ], 200);
        } else {
            return response()->json([
                'status' => 'error',
                'data' => 'Unauthorized Access'
            ], 401);
        }
    }

    /**
     * Fetch all ongoing assignments.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getAssignments(Request $request)
    {
        $assignments = $this->assignmentRepository->getOngoingAssignments();
        return response()->json([
            "assignments" => $assignments,
        ], 200);
    }
}