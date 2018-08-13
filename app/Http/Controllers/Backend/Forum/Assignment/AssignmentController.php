<?php

namespace App\Http\Controllers\Backend\Forum\Assignment;

use App\Models\Forum\Course;
use App\Models\Forum\Assignment;
use App\Http\Controllers\Controller;
use App\Repositories\Backend\Forum\CourseRepository;
use App\Repositories\Backend\Forum\AssignmentRepository;
use App\Events\Backend\Forum\Assignment\AssignmentDeleted;
use App\Http\Requests\Backend\Forum\Assignment\StoreAssignmentRequest;
use App\Http\Requests\Backend\Forum\Assignment\ManageAssignmentRequest;
use App\Http\Requests\Backend\Forum\Assignment\UpdateAssignmentRequest;

/**
 * Class AssignmentController.
 */
class AssignmentController extends Controller
{
    /**
     * @var AssignmentRepository
     * @var CourseRepository
     */
    protected $assignmentRepository, $courseRepository;

    /**
     * AssignmentController + CourseController constructor.
     *
     * @param AssignmentRepository $assignmentRepository
     * @param CourseRepository $courseRepository
     */
    public function __construct(AssignmentRepository $assignmentRepository, CourseRepository $courseRepository)
    {
        $this->assignmentRepository = $assignmentRepository;
        $this->courseRepository = $courseRepository;
    }

    /**
     * @param ManageAssignmentRequest $request
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(ManageAssignmentRequest $request)
    {
        return view('backend.forum.assignment.index')
            ->withAssignments($this->assignmentRepository->getPaginated(25));
    }


    /**
     * @param ManageAssignmentRequest $request
     * @param Course $course
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function specific(ManageAssignmentRequest $request, Course $course)
    {
        return view('backend.forum.assignment.index')
            ->withSpecificCourse($course)
            ->withAssignments($this->assignmentRepository
                ->getPaginatedByCourse($course, 25));
    }

    /**
     * @param ManageAssignmentRequest    $request
     *
     * @return mixed
     */
    public function create(ManageAssignmentRequest $request)
    {
        return view('backend.forum.assignment.create')
            ->withCourseList($this->courseRepository->getCoursePlucked());
    }

    /**
     * @param StoreAssignmentRequest $request
     *
     * @return mixed
     * @throws \Throwable
     */
    public function store(StoreAssignmentRequest $request)
    {
        $this->assignmentRepository->create($request->only(
            'course_id',
            'name',
            'content',
            'due_time'
        ));

        return redirect()->route('admin.forum.assignment.index')->withFlashSuccess(__('alerts.backend.assignments.created'));
    }

    /**
     * @param ManageAssignmentRequest $request
     * @param Assignment              $assignment
     *
     * @return mixed
     */
    public function show(ManageAssignmentRequest $request, Assignment $assignment)
    {
        return view('backend.forum.assignment.show')
            ->withAssignment($assignment);
    }

    /**
     * @param ManageAssignmentRequest    $request
     * @param Assignment                 $assignment
     *
     * @return mixed
     */
    public function edit(ManageAssignmentRequest $request, Assignment $assignment)
    {
        return view('backend.forum.assignment.edit')
            ->withAssignment($assignment);
    }

    /**
     * @param UpdateAssignmentRequest $request
     * @param Assignment              $assignment
     *
     * @return mixed
     * @throws \App\Exceptions\GeneralException
     * @throws \Throwable
     */
    public function update(UpdateAssignmentRequest $request, Assignment $assignment)
    {
        $this->assignmentRepository->update($assignment, $request->only(
            'name',
            'content',
            'due_time'
        ));

        return redirect()->route('admin.forum.assignment.index')->withFlashSuccess(__('alerts.backend.assignments.updated'));
    }

    /**
     * @param ManageAssignmentRequest $request
     * @param Assignment              $assignment
     *
     * @return mixed
     * @throws \Exception
     */
    public function destroy(ManageAssignmentRequest $request, Assignment $assignment)
    {
        $this->assignmentRepository->deleteById($assignment->id);

        event(new AssignmentDeleted($assignment));

        return redirect()->route('admin.forum.assignment.deleted')->withFlashSuccess(__('alerts.backend.assignments.deleted'));
    }
}
