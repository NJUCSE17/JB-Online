<?php

namespace App\Http\Controllers\Backend\Forum\Assignment;

use App\Models\Forum\Assignment;
use App\Http\Controllers\Controller;
use App\Repositories\Backend\Forum\AssignmentRepository;
use App\Http\Requests\Backend\Forum\Assignment\ManageAssignmentRequest;

/**
 * Class AssignmentStatusController.
 */
class AssignmentStatusController extends Controller
{
    /**
     * @var AssignmentRepository
     */
    protected $assignmentRepository;

    /**
     * @param AssignmentRepository $assignmentRepository
     */
    public function __construct(AssignmentRepository $assignmentRepository)
    {
        $this->assignmentRepository = $assignmentRepository;
    }

    /**
     * @param ManageAssignmentRequest $request
     *
     * @return mixed
     */
    public function getDeleted(ManageAssignmentRequest $request)
    {
        return view('backend.forum.assignment.deleted')
            ->withAssignments($this->assignmentRepository->getDeletedPaginated(25, 'id', 'asc'));
    }

    /**
     * @param ManageAssignmentRequest $request
     * @param Assignment              $deletedAssignment
     *
     * @return mixed
     * @throws \App\Exceptions\GeneralException
     * @throws \Throwable
     */
    public function delete(ManageAssignmentRequest $request, Assignment $deletedAssignment)
    {
        $this->assignmentRepository->forceDelete($deletedAssignment);

        return redirect()->route('admin.forum.assignment.deleted')->withFlashSuccess(__('alerts.backend.assignments.deleted_permanently'));
    }

    /**
     * @param ManageAssignmentRequest $request
     * @param Assignment              $deletedAssignment
     *
     * @return mixed
     * @throws \App\Exceptions\GeneralException
     */
    public function restore(ManageAssignmentRequest $request, Assignment $deletedAssignment)
    {
        $this->assignmentRepository->restore($deletedAssignment);

        return redirect()->route('admin.forum.assignment.index')->withFlashSuccess(__('alerts.backend.assignments.restored'));
    }
}
