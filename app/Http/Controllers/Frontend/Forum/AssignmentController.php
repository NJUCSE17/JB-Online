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
        $records = DB::table('assignment_finish_records');
        $exists = $records->where('user_id', '=', \Auth::id())
            ->where('assignment_id', '=', $assignment->id)->exists();
        if ($exists) {
            return json_encode([
                'status' => -1,
                'ddl_badge_api' => '',
                'ddl_badge_class' => '',
                'ddl_badge_content' => '',
                'ddl_badge_finished' => '',
                'prompt' => __('strings.frontend.assignments.finish_fail', ['name' => $assignment->name])
            ]);
        } else {
            $records->insert([
                'user_id' => \Auth::id(),
                'assignment_id' => $assignment->id,
                'finished_at' => \Carbon\Carbon::now(),
            ]);
            return json_encode([
                'status' => 1,
                'ddl_badge_api' => route('frontend.forum.assignment.reset', [$assignment->source, $assignment]),
                'ddl_badge_class' => 'btn btn-sm btn-outline-success resetBtn',
                'ddl_badge_content' => $assignment->ddl_badge_content,
                'ddl_badge_finished' => '1',
                'prompt' => __('strings.frontend.assignments.finish', ['name' => $assignment->name])
            ]);
        }
    }

    /**
     * @var Course
     * @var Assignment
     * @return mixed
     */
    public function reset(Course $course, Assignment $assignment)
    {
        $records = DB::table('assignment_finish_records');
        $exists = $records->where('user_id', '=', \Auth::id())
            ->where('assignment_id', '=', $assignment->id)->exists();
        if ($exists) {
            $records->where('user_id', '=', \Auth::id())
                ->where('assignment_id', '=', $assignment->id)->delete();
            return json_encode([
                'status' => 1,
                'ddl_badge_api' => route('frontend.forum.assignment.finish', [$assignment->source, $assignment]),
                'ddl_badge_class' => "btn btn-sm btn-outline-" . $assignment->ddl_color . " finishBtn",
                'ddl_badge_content' => $assignment->ddl_badge_content,
                'ddl_badge_finished' => '0',
                'prompt' => __('strings.frontend.assignments.reset', ['name' => $assignment->name])
            ]);
        } else {
            return json_encode([
                'status' => -1,
                'ddl_badge_api' => '',
                'ddl_badge_class' => '',
                'ddl_badge_content' => '',
                'ddl_badge_finished' => '',
                'prompt' => __('strings.frontend.assignments.reset_fail', ['name' => $assignment->name])
            ]);
        }
    }
}