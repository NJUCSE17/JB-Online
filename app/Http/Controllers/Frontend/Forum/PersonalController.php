<?php

namespace App\Http\Controllers\Frontend\Forum;

use App\Events\Backend\Forum\Assignment\AssignmentDeleted;
use App\Http\Requests\Frontend\Forum\Personal\ManageAssignmentRequest;
use App\Http\Requests\Frontend\Forum\Personal\StoreAssignmentRequest;
use App\Http\Requests\Frontend\Forum\Personal\UpdateAssignmentRequest;
use App\Models\Forum\Assignment;
use App\Models\Forum\Course;
use App\Http\Controllers\Controller;
use App\Repositories\Frontend\Forum\AssignmentRepository;
use Illuminate\Contracts\View\View;

/**
 * Class PersonalController.
 */
class PersonalController extends Controller
{
    /**
     * @var AssignmentRepository
     */
    protected $assignmentRepository;

    /**
     * PersonalController constructor.
     *
     * @param AssignmentRepository $assignmentRepository
     */
    public function __construct(AssignmentRepository $assignmentRepository)
    {
        $this->assignmentRepository = $assignmentRepository;
    }

    /**
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('frontend.forum.personal.index')
            ->withAssignments($this->assignmentRepository->getPersonalAssignmentsPaginated(\Auth::user()->id));
    }

    /**
     * @return \Illuminate\View\View
     */
    public function finished()
    {
        return view('frontend.forum.personal.index')
            ->withAssignments($this->assignmentRepository->getPersonalFinishedPaginated(\Auth::user()->id));
    }

    /**
     * @param ManageAssignmentRequest    $request
     * @param Assignment                 $assignment
     *
     * @return mixed
     */
    public function edit(ManageAssignmentRequest $request, Assignment $assignment)
    {
        return view('frontend.forum.personal.edit')
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

        return redirect()->route('frontend.forum.personal.index')
            ->withFlashSuccess(__('alerts.frontend.personal.updated'));
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

        return redirect()->route('frontend.forum.personal.index')
            ->withFlashSuccess(__('alerts.frontend.personal.deleted'));
    }


    /**
     * @return mixed
     */
    public function getDeleted()
    {
        return view('frontend.forum.personal.deleted')
            ->withAssignments($this->assignmentRepository->getPersonalDeletedPaginated(\Auth::user()->id));
    }
    
    /**
     * @return mixed
     */
    public function create()
    {
        return view('frontend.forum.personal.create');
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
            'name',
            'content',
            'due_time'
        ));

        return redirect()->route('frontend.forum.personal.index')
            ->withFlashSuccess(__('alerts.frontend.personal.created'));
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

        return redirect()->route('frontend.forum.personal.deleted')
            ->withFlashSuccess(__('alerts.frontend.personal.deleted_permanently'));
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

        return redirect()->route('frontend.forum.personal.deleted')
            ->withFlashSuccess(__('alerts.frontend.personal.restored'));
    }
}