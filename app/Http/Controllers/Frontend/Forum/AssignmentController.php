<?php

namespace App\Http\Controllers\Frontend\Forum;

use App\Models\Forum\Assignment;
use App\Http\Controllers\Controller;
use App\Models\Forum\Course;
use App\Repositories\Frontend\Forum\AssignmentRepository;
use Composer\Util\AuthHelper;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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
     * @param string $sort
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Course $course, Assignment $assignment, string $sort)
    {
        if ($sort == 'dec') {
            return view('frontend.forum.assignment')
                ->withCourse($assignment->source)
                ->withAssignment($assignment)
                ->withSorted('dec')
                ->withUserid(Auth::id())
                ->withPosts($assignment->getGroupedPosts('dec'));
        } else {
            return view('frontend.forum.assignment')
                ->withCourse($assignment->source)
                ->withAssignment($assignment)
                ->withSorted('asc')
                ->withUserid(Auth::id())
                ->withPosts($assignment->getGroupedPosts('asc'));
        }
    }

    /**
     * @var Course
     * @var Assignment
     * @return mixed
     */
    public function finish(Course $course, Assignment $assignment)
    {
        $assignment->finish();
        return response()->json([
            'success' => true,
            'button_html' => $assignment->getDDLButtonAttribute(),
            'ddl_html' => $assignment->getDDLContentAttribute(),
        ], 200);
    }

    /**
     * @var Course
     * @var Assignment
     * @return mixed
     */
    public function reset(Course $course, Assignment $assignment)
    {
        $assignment->reset();
        return response()->json([
            'success' => true,
            'button_html' => $assignment->getDDLButtonAttribute(),
            'ddl_html' => $assignment->getDDLContentAttribute(),
        ], 200);
    }
}