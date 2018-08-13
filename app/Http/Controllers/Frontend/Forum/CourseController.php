<?php

namespace App\Http\Controllers\Frontend\Forum;

use App\Models\Forum\Course;
use App\Http\Controllers\Controller;
use App\Repositories\Frontend\Forum\CourseRepository;

/**
 * Class CourseController.
 */
class CourseController extends Controller
{
    /**
     * @var CourseRepository
     */
    protected $courseRepository;

    /**
     * CourseController constructor.
     *
     * @param CourseRepository $courseRepository,
     *        AssignmentRepository $assignmentRepository
     */
    public function __construct(CourseRepository $courseRepository)
    {
       $this->courseRepository = $courseRepository;
    }

    /**
     * @param Course $course
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Course $course)
    {
        return view('frontend.forum.course')
            ->withCourse($course)
            ->withAssignments($course->getAssignments());
    }
}