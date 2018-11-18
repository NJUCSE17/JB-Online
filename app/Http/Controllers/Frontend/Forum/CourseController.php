<?php

namespace App\Http\Controllers\Frontend\Forum;

use App\Models\Forum\Course;
use App\Http\Controllers\Controller;
use App\Repositories\Frontend\Forum\CourseRepository;
use Illuminate\Contracts\View\View;

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
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('frontend.forum.all')
            ->withCourses($this->courseRepository->getAllCourses());
    }

    /**
     * @param Course $course
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function specific(Course $course)
    {
        return view('frontend.forum.course')
            ->withCourse($course)
            ->withAssignments($course->getAssignments());
    }
}