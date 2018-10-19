<?php

namespace App\Http\Controllers\Backend\Forum\Problem;

use App\Models\Forum\Assignment;
use App\Models\Forum\Problem;
use App\Http\Controllers\Controller;
use App\Events\Backend\Forum\Problem\ProblemDeleted;
use App\Repositories\Backend\Forum\ProblemRepository;
use App\Http\Requests\Backend\Forum\Problem\StoreProblemRequest;
use App\Http\Requests\Backend\Forum\Problem\ManageProblemRequest;
use App\Http\Requests\Backend\Forum\Problem\UpdateProblemRequest;
use Illuminate\Support\Facades\Auth;

/**
 * Class ProblemController.
 */
class ProblemController extends Controller
{
    /**
     * @var ProblemRepository
     */
    protected $problemRepository;

    /**
     * ProblemController constructor.
     *
     * @param ProblemRepository $problemRepository
     */
    public function __construct(ProblemRepository $problemRepository)
    {
        $this->problemRepository = $problemRepository;
    }

    /**
     * @param ManageProblemRequest $request
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(ManageProblemRequest $request)
    {
        return view('backend.forum.problem.index')
            ->withProblems($this->problemRepository->getPaginated(25));
    }

    /**
     * @param ManageProblemRequest    $request
     *
     * @return mixed
     */
    public function create(ManageProblemRequest $request)
    {
        return view('backend.forum.problem.create');
    }

    /**
     * @param ManageProblemRequest $request
     * @param Assignment $assignment
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function createSpecific(ManageProblemRequest $request, Assignment $assignment)
    {
        return view('backend.forum.problem.create')
            ->withSpecificAssignment($assignment);
    }

    /**
     * @param ManageProblemRequest $request
     * @param Assignment $assignment
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function specific(ManageProblemRequest $request, Assignment $assignment)
    {
        return view('backend.forum.problem.index')
            ->withSpecificAssignment($assignment)
            ->withProblems($this->problemRepository
                ->getPaginatedByAssignment($assignment, 25));
    }

    /**
     * @param ManageProblemRequest $request
     * @param Problem              $problem
     *
     * @return mixed
     */
    public function show(ManageProblemRequest $request, Problem $problem)
    {
        return view('backend.forum.problem.show')
            ->withProblem($problem);
    }

    /**
     * @param StoreProblemRequest $request
     *
     * @return mixed
     * @throws \Throwable
     */
    public function store(StoreProblemRequest $request)
    {
        $data = $request->only('course_id', 'assignment_id', 'permalink', 'content', 'difficulty');
        $this->problemRepository->create($data);

        return redirect()->route('admin.forum.problem.specific', [$request['assignment_id']])->withFlashSuccess(__('alerts.backend.problems.created'));
    }

    /**
     * @param ManageProblemRequest    $request
     * @param Problem                 $problem
     *
     * @return mixed
     */
    public function edit(ManageProblemRequest $request, Problem $problem)
    {
        return view('backend.forum.problem.edit')
            ->withProblem($problem);
    }

    /**
     * @param UpdateProblemRequest $request
     * @param Problem              $problem
     *
     * @return mixed
     * @throws \App\Exceptions\GeneralException
     * @throws \Throwable
     */
    public function update(UpdateProblemRequest $request, Problem $problem)
    {
        $data = $request->only('permalink', 'content', 'difficulty');
        $this->problemRepository->update($problem, $data);

        return redirect()->route('admin.forum.problem.index')->withFlashSuccess(__('alerts.backend.problems.updated'));
    }

    /**
     * @param ManageProblemRequest $request
     * @param Problem              $problem
     *
     * @return mixed
     * @throws \Exception
     */
    public function destroy(ManageProblemRequest $request, Problem $problem)
    {
        $this->problemRepository->deleteById($problem->id);

        event(new ProblemDeleted($problem));

        return redirect()->route('admin.forum.problem.index')->withFlashSuccess(__('alerts.backend.problems.deleted'));
    }
}
