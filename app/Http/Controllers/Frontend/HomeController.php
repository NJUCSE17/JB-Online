<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Repositories\Frontend\Forum\CourseRepository;
use App\Repositories\Frontend\Forum\NoticeRepository;
use App\Repositories\Frontend\Forum\AssignmentRepository;

/**
 * Class HomeController.
 */
class HomeController extends Controller
{
    /**
     * @var AssignmentRepository
     * @var CourseRepository
     * @var NoticeRepository
     */
    protected $assignmentRepository, $courseRepository, $noticeRepository;

    /**
     * AssignmentController & CourseController constructor.
     *
     * @param AssignmentRepository $assignmentRepository
     * @param CourseRepository $courseRepository
     */
    public function __construct(AssignmentRepository $assignmentRepository,
                                CourseRepository $courseRepository,
                                NoticeRepository $noticeRepository)
    {
        $this->assignmentRepository = $assignmentRepository;
        $this->courseRepository = $courseRepository;
        $this->noticeRepository = $noticeRepository;
    }

    /**
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('frontend.index')
            ->withNotice($this->noticeRepository->getNotice())
            ->withOngoingCourses($this->courseRepository->getOngoingCourses())
            ->withAllCourses($this->courseRepository->getAllCourses())
            ->withAssignments($this->assignmentRepository->getOngoingAssignments());
    }

    /**
     * @return \Illuminate\View\View
     */
    public function about()
    {
        return view('frontend.about');
    }
}
