<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Forum\BlogFeed;
use App\Repositories\Frontend\Auth\UserRepository;
use App\Repositories\Frontend\Forum\CourseRepository;
use App\Repositories\Frontend\Forum\NoticeRepository;
use App\Repositories\Frontend\Forum\AssignmentRepository;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;
use Mews\Purifier\Facades\Purifier;

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
        if (Auth::hasUser()) return redirect()->route('frontend.home');
        return redirect()->route('frontend.auth.login');
    }

    /**
     * @return \Illuminate\View\View
     */
    public function home()
    {
        $feeds = array();
        if(app_blogonhome()) {
            $originFeed = \Feeds::make([app_blogrss()], 5, false);
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

        return view('frontend.home')
            ->withNotice($this->noticeRepository->getNotice())
            ->withOngoingCourses($this->courseRepository->getOngoingCourses())
            ->withAssignments($this->assignmentRepository->getOngoingAssignments())
            ->withFeeds(collect($feeds));
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
        return view('frontend.blog')
            ->withFeeds(BlogFeed::query()->orderBy('date', 'DESC')->paginate(5));
    }
}
