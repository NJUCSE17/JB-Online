<?php
/**
 * Created by PhpStorm.
 * User: Tianyun Zhang
 * Date: 2019/1/19
 * Time: 21:21
 */

namespace App\Http\Controllers\API\Forum;


use App\Repositories\Frontend\Forum\AssignmentRepository;

class AssignmentController
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