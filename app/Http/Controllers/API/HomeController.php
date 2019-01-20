<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Forum\Assignment;
use App\Repositories\Frontend\Forum\NoticeRepository;
use App\Repositories\Frontend\Forum\AssignmentRepository;
use Carbon\Traits\Timestamp;
use http\Env\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Validation\Rules\In;

class HomeController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/heatmap",
     *     tags={"Utils"},
     *     summary="Get the JSON data of heatmap on index page.",
     *     @OA\Parameter(
     *         name="st",
     *         description="Start time (in timestamp format).",
     *         required=false,
     *         in="query",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Parameter(
     *         name="ed",
     *         description="End time (in timestamp format).",
     *         required=false,
     *         in="query",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response=200, description="Successful operation",
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(ref="#/components/schemas/Heatmap"),
     *         )
     *     ),
     * )
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function heatmap(Request $request)
    {
        $userID = (Input::get('userID', 0));
        $st = (Input::get('st', 0));
        $ed = (Input::get('ed', 0));
        $assignments = $this->assignmentRepository
            ->getAssignmentsByTimestamps($userID, $st, $ed);
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
     * @OA\Get(
     *     path="/api/app",
     *     tags={"Utils"},
     *     summary="Get the JSON data of latest mobile app info.",
     *     @OA\Response(response=200, description="Successful operation",
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(ref="#/components/schemas/AppInfo"),
     *         )
     *     ),
     * )
     *
     * @param Request $request
     * @param string $app
     * @return \Illuminate\Http\JsonResponse
     */
    public function app(Request $request, $app = 'android')
    {
        return response()->json(mobile_app_version(), 200);
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