<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Repositories\Frontend\Auth\UserRepository;
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
     * @var UserRepository
     */
    protected $assignmentRepository, $courseRepository, $noticeRepository, $userRepository;

    /**
     * AssignmentController & CourseController constructor.
     *
     * @param AssignmentRepository $assignmentRepository
     * @param CourseRepository $courseRepository
     * @param NoticeRepository $noticeRepository
     * @param UserRepository $userRepository
     */
    public function __construct(AssignmentRepository $assignmentRepository,
                                CourseRepository $courseRepository,
                                NoticeRepository $noticeRepository,
                                UserRepository $userRepository)
    {
        $this->assignmentRepository = $assignmentRepository;
        $this->courseRepository = $courseRepository;
        $this->noticeRepository = $noticeRepository;
        $this->userRepository = $userRepository;
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

    /**
     * @return \Illuminate\View\View
     */
    public function blog()
    {
        $feeds = array();
        $users = $this->userRepository->getAllUsers();
        foreach ($users as $user) {
            if ($user->blog != null) {
                $originFeed = \Feeds::make([$user->blog], 5, false);
                $items = $originFeed->get_items();
                foreach ($items as $item) {
                    //$description = $item->get_description();
                    //$regex = '/(<[^>]+>)/is';
                    //$content = preg_replace($regex, '', $description);

                    $date = \Carbon\Carbon::parse($item->get_date());
                    $feeds[] = array(
                        'permalink'   => $item->get_permalink(),
                        'title'       => $item->get_title(),
                        'content'     => $item->get_content(),
                        'author'      => $user->full_name,
                        'avatar'      => $user->picture,
                        'date'        => $date,
                    );
                }
            }
        }
        // sort feeds by time
        usort($feeds, function ($a, $b) {
            return ($a['date'] < $b['date']) ? 1 : -1;
        });

        return view('frontend.blog')
            ->withFeeds($feeds);
    }
}
