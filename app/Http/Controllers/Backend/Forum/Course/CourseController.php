<?php

namespace App\Http\Controllers\Backend\Forum\Course;

use App\Models\Forum\Course;
use App\Http\Controllers\Controller;
use App\Events\Backend\Forum\Course\CourseDeleted;
use App\Repositories\Backend\Forum\CourseRepository;
use App\Http\Requests\Backend\Forum\Course\StoreCourseRequest;
use App\Http\Requests\Backend\Forum\Course\ManageCourseRequest;
use App\Http\Requests\Backend\Forum\Course\UpdateCourseRequest;
use Illuminate\Support\Facades\Auth;

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
     * @param Course              $course
     *
     * @return mixed
     * @throws \Exception
     */
    public function destroy(ManageCourseRequest $request, Course $course)
    {
        $this->courseRepository->deleteById($course->id);

        event(new CourseDeleted($course));

        return redirect()->route('admin.forum.course.deleted')->withFlashSuccess(__('alerts.backend.courses.deleted'));
    }
}
