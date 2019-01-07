<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Forum\Assignment;
use App\Repositories\Frontend\Forum\NoticeRepository;
use App\Repositories\Frontend\Forum\AssignmentRepository;
use Carbon\Traits\Timestamp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Validation\Rules\In;

class UserController extends Controller
{
    /**
     * @var AssignmentRepository
     * @var NoticeRepository
     */
    protected $assignmentRepository, $noticeRepository;

    /**
     * UserController constructor.
     *
     * @param AssignmentRepository $assignmentRepository
     * @param NoticeRepository $noticeRepository
     */
    public function __construct(AssignmentRepository $assignmentRepository,
                                NoticeRepository $noticeRepository)
    {
        $this->assignmentRepository = $assignmentRepository;
        $this->noticeRepository = $noticeRepository;
    }

    /**
     * @OA\Get(
     *     path="/api/heatmap",
     *     tags={"Utils"},
     *     summary="Get the JSON data of heatmap on index page",
     *     @OA\Parameter(
     *         name="st",
     *         description="Start time (in timestamp format).",
     *         required=false,
     *         in="query",
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="ed",
     *         description="End time (in timestamp format).",
     *         required=false,
     *         in="query",
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\Response(response=200, description="Successful operation",
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(ref="#/components/schemas/Heatmap"),
     *         )
     *     ),
     * )
     */
    public function heatmap(Request $request)
    {
        $st = (Input::get('st', 0));
        $ed = (Input::get('ed', 0));
        $assignments = $this->assignmentRepository
            ->getAssignmentsByTimestamps($st, $ed);
        $jsonValueArray = array();
        foreach ($assignments as $assignment) {
            $timestamp = date_timestamp_get($assignment->due_time);
            if (isset($jsonValueArray[$timestamp])) {
                $jsonValueArray[$timestamp]++;
            } else {
                $jsonValueArray[$timestamp] = 1;
            }
        }
        return response()->json($jsonValueArray);
    }

    /**
     * @OA\Post(
     *     path="/api/app",
     *     tags={"Utils"},
     *     summary="Get the JSON data of latest mobile app info",
     *     @OA\Response(response=200, description="Successful operation",
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(ref="#/components/schemas/AppInfo"),
     *         )
     *     ),
     * )
     */
    public function app(Request $request)
    {
        return response()->json([
            "data" => mobile_app_version(),
        ], 200);
    }



    /**
     * @OA\Post(
     *     path="/oauth/token",
     *     tags={"Authenticate"},
     *     summary="Authenticate and get API token",
     *     @OA\Parameter(
     *         name="student_id",
     *         description="Student ID. Can use 'username' instead.",
     *         required=true,
     *         in="query",
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="password",
     *         description="Account password.",
     *         required=true,
     *         in="query",
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Response(response=200, description="Authenticate success",
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(ref="#/components/schemas/LoginSuccess"),
     *         )
     *     ),
     *     @OA\Response(response=401, description="Authenticate failure",
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(ref="#/components/schemas/NormalMessage"),
     *         )
     *     ),
     * )
     */

    /**
     * @OA\Post(
     *     path="/api/logout",
     *     tags={"Authenticate"},
     *     summary="Logout and revoke API token",
     *     @OA\Response(response=200, description="Authenticate success",
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(ref="#/components/schemas/NormalMessage"),
     *         )
     *     ),
     *     security={{"passport": {}}},
     * )
     */
    /**
     * API for logout.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout(Request $request)
    {
        $user = Auth::user();
        $user->token()->revoke();
        return response()->json([
            'status' => 'success',
            'message' => 'Successfully logged out as ' . $user->full_name . '.',
        ], 200);
    }

    /**
     * Fetch the current notice.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getNotice(Request $request)
    {
        return response()->json([
            "data" => $this->noticeRepository->APIGetNotice(),
        ], 200);
    }

    /**
     * Fetch all ongoing assignments.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getAssignments(Request $request)
    {
        return response()->json([
            "data" => $this->assignmentRepository->APIGetOngoingAssignments(),
        ], 200);
    }

    /**
     * @var Request
     * @var Assignment
     * @return mixed
     */
    public function finishAssignment(Request $request, Assignment $assignment)
    {
        $assignment->finish();
        return response()->json([
            'status' => 'success',
            'data' => $this->assignmentRepository->APIGetOngoingAssignments(),
        ], 200);
    }

    /**
     * @var Request
     * @var Assignment
     * @return mixed
     */
    public function resetAssignment(Request $request, Assignment $assignment)
    {
        $assignment->reset();
        return response()->json([
            'status' => 'success',
            'data' => $this->assignmentRepository->APIGetOngoingAssignments(),
        ], 200);
    }
}

/**
 * @OA\Schema()
 */
class Heatmap {
    /**
     * The number of entries of a timestamp
     * @var integer
     * @OA\Property()
     */
    public $timestamp;
}

/**
 * @OA\Schema()
 */
class AppInfo {
    /**
     * App data
     * @var AppInfo_Data
     * @OA\Property()
     */
    public $data;
}

/**
 * @OA\Schema()
 */
class AppInfo_Data {
    /**
     * Version number
     * @var integer
     * @OA\Property()
     */
    public $number;
    /**
     * Version name
     * @var string
     * @OA\Property()
     */
    public $name;
    /**
     * Version info
     * @var string
     * @OA\Property()
     */
    public $info;
    /**
     * App download link
     * @var string
     * @OA\Property()
     */
    public $link;
}

/**
 * @OA\Schema()
 */
class LoginSuccess {
    /**
     * "success"
     * @var string
     * @OA\Property()
     */
    public $status;
    /**
     * API Message
     * @var string
     * @OA\Property()
     */
    public $message;
    /**
     * User ID
     * @var integer
     * @OA\Property()
     */
    public $user_id;
    /**
     * User Name
     * @var string
     * @OA\Property()
     */
    public $user_name;
    /**
     * API Token
     * @var string
     * @OA\Property()
     */
    public $token;
}

/**
 * @OA\Schema()
 */
class NormalMessage {
    /**
     * API Returning Status
     * @var string
     * @OA\Property()
     */
    public $status;
    /**
     * API Message
     * @var string
     * @OA\Property()
     */
    public $message;
}