<?php

namespace App\Http\Controllers\API\Forum;

use App\Http\Controllers\Controller;
use App\Models\Forum\Assignment;
use App\Repositories\API\Forum\AssignmentRepository;
use Illuminate\Support\Facades\Request;

class AssignmentController extends Controller
{
    /**
     * @var AssignmentRepository
     */
    protected $assignmentRepository;

    /**
     * AssignmentController constructor.
     * @param AssignmentRepository $assignmentRepository
     */
    public function __construct(AssignmentRepository $assignmentRepository)
    {
        $this->assignmentRepository = $assignmentRepository;
    }

    /**
     * @OA\Get(
     *     path="/api/assignments",
     *     tags={"Assignment"},
     *     summary="Get all ongoing assignments.",
     *     security={{"passport" : {}}},
     *     @OA\Response(response=200, description="Successful operation",
     *         @OA\JSONContent(
     *             @OA\Property(
     *                 property="assignments", type="array",
     *                 description="An array of assignments",
     *                 items=@OA\Property(ref="#/components/schemas/AssignmentInfo")
     *             )
     *         )
     *     )
     * )
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getAssignments(Request $request)
    {
        return response()->json([
            "assignments" => $this->assignmentRepository->getOngoingAssignments(),
        ], 200);
    }

    /**
     * @OA\Post(
     *     path="/api/assignment/{assignment_id}/finish",
     *     tags={"Assignment"},
     *     summary="Mark an assignment as finished and update assignments.",
     *     security={{"passport" : {}}},
     *     @OA\Parameter(
     *         name="assignment_id",
     *         description="Numeric ID of the assignment.",
     *         required=true,
     *         in="path",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response=200, description="Successful operation",
     *         @OA\JSONContent(
     *             @OA\Property(
     *                 property="assignments", type="array",
     *                 description="An array of assignments",
     *                 items=@OA\Property(ref="#/components/schemas/AssignmentInfo")
     *             )
     *         )
     *     )
     * )
     *
     * @var Request
     * @var Assignment
     * @return mixed
     */
    public function finishAssignment(Request $request, Assignment $assignment)
    {
        $assignment->finish();
        return response()->json([
            'assignments' => $this->assignmentRepository->getOngoingAssignments(),
        ], 200);
    }

    /**
     * @OA\Post(
     *     path="/api/assignment/{assignment_id}/reset",
     *     tags={"Assignment"},
     *     summary="Mark an assignment as unfinished and update assignments.",
     *     security={{"passport" : {}}},
     *     @OA\Parameter(
     *         name="assignment_id",
     *         description="Numeric ID of the assignment.",
     *         required=true,
     *         in="path",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response=200, description="Successful operation",
     *         @OA\JSONContent(
     *             @OA\Property(
     *                 property="assignments", type="array",
     *                 description="An array of assignments",
     *                 items=@OA\Property(ref="#/components/schemas/AssignmentInfo")
     *             )
     *         )
     *     )
     * )
     *
     * @var Request
     * @var Assignment
     * @return mixed
     */
    public function resetAssignment(Request $request, Assignment $assignment)
    {
        $assignment->reset();
        return response()->json([
            'assignments' => $this->assignmentRepository->getOngoingAssignments(),
        ], 200);
    }
}

/**
 * @OA\Schema()
 */
class AssignmentInfo
{
    /**
     * Numeric ID of the assignment.
     *
     * @var integer
     * @OA\Property()
     */
    public $id;

    /**
     * Numeric ID of the source course of assignment.
     *
     * @var integer
     * @OA\Property()
     */
    public $course_id;

    /**
     * Name of the assignment.
     *
     * @var string
     * @OA\Property()
     */
    public $name;

    /**
     * Content of the assignment.
     *
     * @var string
     * @OA\Property()
     */
    public $content;

    /**
     * Deadline of the assignment.
     *
     * @var string
     * @OA\Property()
     */
    public $due_time;

    /**
     * Numeric ID of the issuer of the assignment.
     *
     * @var integer
     * @OA\Property()
     */
    public $issuer;

    /**
     * Whether the assignment is finished.
     *
     * @var boolean
     * @OA\Property()
     */
    public $finished;
}