<?php

namespace App\Http\Controllers\Backend\Forum\Course;

use App\Models\Forum\Course;
use App\Http\Controllers\Controller;
use App\Repositories\Backend\Forum\CourseRepository;
use App\Http\Requests\Backend\Forum\Course\ManageCourseRequest;

/**
 * Class CourseStatusController.
 */
class CourseStatusController extends Controller
{
    /**
     * @var CourseRepository
     */
    protected $courseRepository;

    /**
     * @param CourseRepository $courseRepository
     */
    public function __construct(CourseRepository $courseRepository)
    {
        $this->courseRepository = $courseRepository;
    }

    /**
     * @param ManageCourseRequest $request
     *
     * @return mixed
     */
    public function getDeleted(ManageCourseRequest $request)
    {
        return view('backend.forum.course.deleted')
            ->withCourses($this->courseRepository->getDeletedPaginated(25, 'id', 'asc'));
    }

    /**
     * @param ManageCourseRequest $request
     * @param Course              $deletedCourse
     *
     * @return mixed
     * @throws \App\Exceptions\GeneralException
     * @throws \Throwable
     */
    public function delete(ManageCourseRequest $request, Course $deletedCourse)
    {
        $this->courseRepository->forceDelete($deletedCourse);

        return redirect()->route('admin.forum.course.deleted')->withFlashSuccess(__('alerts.backend.courses.deleted_permanently'));
    }

    /**
     * @param ManageCourseRequest $request
     * @param Course              $deletedCourse
     *
     * @return mixed
     * @throws \App\Exceptions\GeneralException
     */
    public function restore(ManageCourseRequest $request, Course $deletedCourse)
    {
        $this->courseRepository->restore($deletedCourse);

        return redirect()->route('admin.forum.course.index')->withFlashSuccess(__('alerts.backend.courses.restored'));
    }
}
