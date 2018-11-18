<?php

namespace App\Http\Controllers\Backend\Forum\Problem;

use App\Models\Forum\Problem;
use App\Http\Controllers\Controller;
use App\Repositories\Backend\Forum\ProblemRepository;
use App\Http\Requests\Backend\Forum\Problem\ManageProblemRequest;

/**
 * Class ProblemStatusController.
 */
class ProblemStatusController extends Controller
{
    /**
     * @var ProblemRepository
     */
    protected $problemRepository;

    /**
     * @param ProblemRepository $problemRepository
     */
    public function __construct(ProblemRepository $problemRepository)
    {
        $this->problemRepository = $problemRepository;
    }

    /**
     * @param ManageProblemRequest $request
     *
     * @return mixed
     */
    public function getDeleted(ManageProblemRequest $request)
    {
        return view('backend.forum.problem.deleted')
            ->withProblems($this->problemRepository->getDeletedPaginated(25, 'id', 'asc'));
    }

    /**
     * @param ManageProblemRequest $request
     * @param Problem              $deletedProblem
     *
     * @return mixed
     * @throws \App\Exceptions\GeneralException
     * @throws \Throwable
     */
    public function delete(ManageProblemRequest $request, Problem $deletedProblem)
    {
        $this->problemRepository->forceDelete($deletedProblem);

        return redirect()->route('admin.forum.problem.deleted')->withFlashSuccess(__('alerts.backend.problems.deleted_permanently'));
    }

    /**
     * @param ManageProblemRequest $request
     * @param Problem              $deletedProblem
     *
     * @return mixed
     * @throws \App\Exceptions\GeneralException
     */
    public function restore(ManageProblemRequest $request, Problem $deletedProblem)
    {
        $this->problemRepository->restore($deletedProblem);

        return redirect()->route('admin.forum.problem.deleted')->withFlashSuccess(__('alerts.backend.problems.restored'));
    }
}
