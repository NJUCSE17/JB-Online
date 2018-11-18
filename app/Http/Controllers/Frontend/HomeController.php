<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Repositories\Frontend\Auth\UserRepository;
use App\Repositories\Frontend\Forum\CourseRepository;
use App\Repositories\Frontend\Forum\NoticeRepository;
use App\Repositories\Frontend\Forum\AssignmentRepository;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;

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

        $feeds = array();
        if(app_blogonhome()) {
            $originFeed = \Feeds::make(app_blogrss(), 0, false);
            $items = $originFeed->get_items();
            foreach ($items as $item) {
                //$description = $item->get_description();
                //$regex = '/(<[^>]+>)/is';
                //$content = preg_replace($regex, '', $description);

                $date = \Carbon\Carbon::parse($item->get_date());
                $feeds[] = array(
                    'permalink'   => $item->get_permalink(),
                    'title'       => $item->get_title(),
                    'date'        => $date,
                );
            }
        }

        return view('frontend.index')
            ->withNotice($this->noticeRepository->getNotice())
            ->withOngoingCourses($this->courseRepository->getOngoingCourses())
            ->withAssignments($this->assignmentRepository->getOngoingAssignments())
            ->withFeeds(collect($feeds));
    }

    /**
     * @return \Illuminate\View\View
     */
    public function course()
    {
        return view('frontend.course')
            ->withCourses($this->courseRepository->getAllCourses());
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
                $originFeed = \Feeds::make([$user->blog], 0, false);
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
        // slice feeds
        $currentPage  = isset($_GET['page']) ? (int) $_GET['page'] : 1;
        $currentPath  = Paginator::resolveCurrentPath();
        $perPage      = 5;
        $slicedFeeds  = array_slice($feeds, $perPage * ($currentPage - 1), $perPage);
        $paginatedFeeds = new LengthAwarePaginator($slicedFeeds, count($feeds), $perPage, $currentPage, [
            'path' => $currentPath,
        ]);

        return view('frontend.blog')
            ->withFeeds($paginatedFeeds);
    }
}
