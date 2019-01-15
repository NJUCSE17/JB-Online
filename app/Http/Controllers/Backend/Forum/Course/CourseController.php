<?php

namespace App\Http\Controllers\Backend\Forum\Course;

use App\Models\Auth\User;
use App\Models\Forum\Course;
use App\Http\Controllers\Controller;
use App\Events\Backend\Forum\Course\CourseDeleted;
use App\Repositories\Backend\Auth\UserRepository;
use App\Repositories\Backend\Forum\CourseRepository;
use App\Http\Requests\Backend\Forum\Course\StoreCourseRequest;
use App\Http\Requests\Backend\Forum\Course\ManageCourseRequest;
use App\Http\Requests\Backend\Forum\Course\UpdateCourseRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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
     * @param CourseRepository $courseRepository
     */
    public function __construct(CourseRepository $courseRepository)
    {
        $this->courseRepository = $courseRepository;
    }

    /**
     * @param ManageCourseRequest $request
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(ManageCourseRequest $request)
    {
        return view('backend.forum.course.index')
            ->withCourses($this->courseRepository->getPaginated(25));
    }

    /**
     * @param ManageCourseRequest    $request
     *
     * @return mixed
     */
    public function create(ManageCourseRequest $request)
    {
        return view('backend.forum.course.create');
    }

    /**
     * @param StoreCourseRequest $request
     *
     * @return mixed
     * @throws \Throwable
     */
    public function store(StoreCourseRequest $request)
    {
        $data = $request->only(
            'name',
            'semester',
            'start_time',
            'end_time',
            'notice',
            'difficulty',
            'restrict_level');
        $data['user_id'] = Auth::id();
        $this->courseRepository->create($data);

        return redirect()->route('admin.forum.course.index')->withFlashSuccess(__('alerts.backend.courses.created'));
    }

    /**
     * @param ManageCourseRequest $request
     * @param Course              $course
     *
     * @return mixed
     */
    public function show(ManageCourseRequest $request, Course $course)
    {
        return view('backend.forum.course.show')
            ->withCourse($course);
    }

    /**
     * @param ManageCourseRequest    $request
     * @param Course                 $course
     *
     * @return mixed
     */
    public function edit(ManageCourseRequest $request, Course $course)
    {
        return view('backend.forum.course.edit')
            ->withCourse($course);
    }

    /**
     * @param UpdateCourseRequest $request
     * @param Course              $course
     *
     * @return mixed
     * @throws \App\Exceptions\GeneralException
     * @throws \Throwable
     */
    public function update(UpdateCourseRequest $request, Course $course)
    {
        $data = $request->only(
            'name',
            'semester',
            'start_time',
            'end_time',
            'notice',
            'difficulty',
            'restrict_level');
        $data['user_id'] = Auth::id();
        $this->courseRepository->update($course, $data);

        return redirect()->route('admin.forum.course.index')->withFlashSuccess(__('alerts.backend.courses.updated'));
    }

    /**
     * @param ManageCourseRequest $request
     * @param Course $course
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showEnrollment(ManageCourseRequest $request, Course $course)
    {
        $records = DB::table('course_enroll_records')
            ->where('course_id', $course->id)
            ->get();
        $students = Array();
        $admins = Array();
        foreach ($records as $record) {
            if ($record->type_is_admin) {
                $admins[] = User::where('id', $record->user_id)->first();
            } else {
                $students[] = User::where('id', $record->user_id)->first();
            }
        }

        return view('backend.forum.course.enroll')
            ->with('course', $course)
            ->with('students', $students)
            ->with('admins', $admins);
    }

    /**
     * @param ManageCourseRequest $request
     * @param Course $course
     * @return mixed
     */
    public function editEnrollment(ManageCourseRequest $request, Course $course)
    {
        $data = $request->only('type', 'student_id');
        $user = User::where('student_id', $data['student_id'])->first();
        if (!$user) return redirect()->back()
            ->withFlashDanger('Student with sid ' . $data['student_id'] . ' is not found.');

        if (!$data['type']) {
            /* delete user from course */
            $course->deleteUser($user);
            return redirect()->back()
                ->withFlashSuccess('Successfully deleted ' . $user->name . ' from course ' . $course->name . '.');
        } else {
            if ($data['type'] == 1) {
                /* add as a student */
                $course->addStudent($user);
                return redirect()->back()
                    ->withFlashSuccess('Successfully added ' . $user->name . ' as student of ' . $course->name . '.');
            } else {
                /* add as an admin */
                $course->addAdmin($user);
                return redirect()->back()
                    ->withFlashSuccess('Successfully added ' . $user->name . ' as admin of ' . $course->name . '.');
            }
        }
    }

    /**
     * @param ManageCourseRequest $request
     * @param Course              $course
     *
     * @return mixed
     * @throws \Exception
     */
    public function destroy(ManageCourseRequest $request, Course $course)
    {
        $this->courseRepository->deleteById($course->id);

        event(new CourseDeleted($course));

        return redirect()->route('admin.forum.course.index')->withFlashSuccess(__('alerts.backend.courses.deleted'));
    }
}
