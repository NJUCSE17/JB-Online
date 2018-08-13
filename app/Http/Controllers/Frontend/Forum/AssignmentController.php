<?php

namespace App\Http\Controllers\Frontend\Forum;

use App\Models\Forum\Assignment;
use App\Http\Controllers\Controller;
use App\Models\Forum\Course;
use App\Repositories\Frontend\Forum\AssignmentRepository;
use Illuminate\Support\Facades\Auth;

/**
 * Class AssignmentController.
 */
class AssignmentController extends Controller
{
    /**
     * @var AssignmentRepository
     */
    protected $assignmentRepository;

    /**
     * PostController constructor.
     *
     * @param AssignmentRepository $assignmentRepository
     */
    public function __construct(AssignmentRepository $assignmentRepository)
    {
        $this->assignmentRepository = $assignmentRepository;
    }

    /**
     * @param Course $course
     * @param Assignment $assignment
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Course $course, Assignment $assignment)
    {
        return view('frontend.forum.assignment')
            ->withCourse($assignment->source)
            ->withAssignment($assignment)
            ->withSorted('asc')
            ->withUserid(Auth::id())
            ->withPosts($assignment->getGroupedPosts('asc'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function indexRev(Course $course, Assignment $assignment)
    {
        return view('frontend.forum.assignment')
            ->withCourse($assignment->source)
            ->withAssignment($assignment)
            ->withSorted('dec')
            ->withUserid(Auth::id())
            ->withPosts($assignment->getGroupedPosts('dec'));
    }
}