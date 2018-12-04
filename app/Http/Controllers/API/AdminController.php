<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Repositories\Frontend\Forum\AssignmentRepository;

class AdminController extends Controller
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
}