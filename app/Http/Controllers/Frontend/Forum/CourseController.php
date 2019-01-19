<?php

namespace App\Http\Controllers\Frontend\Forum;

use App\Models\Auth\User;
use App\Models\Forum\Course;
use App\Http\Controllers\Controller;
use App\Repositories\Frontend\Forum\CourseRepository;
use App\Http\Controllers\API\Forum\CourseController as API;
use Illuminate\Support\Facades\Request;

/**
 * Class CourseController.
 */
class CourseController extends Controller
{
    /**
     * @var CourseRepository
     */
    protected $courseRepository;
    protected $courseAPI;

    /**
     * CourseController constructor.
     *
     * @param CourseRepository $courseRepository,
     *        AssignmentRepository $assignmentRepository
     */
    public function __construct(CourseRepository $courseRepository, API $api)
    {
       $this->courseRepository = $courseRepository;
       $this->courseAPI = $api;
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

    /**
     * @param Request $request
     * @param Course $course
     * @param User $user
     * @return \Illuminate\Http\JsonResponse
     */
    public function addStudent(Request $request, Course $course, User $user = null)
    {
        return $this->courseAPI->addStudent($request, $course, $user);
    }

    /**
     * @param Request $request
     * @param Course $course
     * @param User $user
     * @return \Illuminate\Http\JsonResponse
     */
    public function addAdmin(Request $request, Course $course, User $user = null)
    {
        return $this->courseAPI->addAdmin($request, $course, $user);
    }

    /**
     * @param Request $request
     * @param Course $course
     * @param User|null $user
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteUser(Request $request, Course $course, User $user = null)
    {
        return $this->courseAPI->deleteUser($request, $course, $user);
    }
}