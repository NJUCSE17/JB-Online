<?php

namespace App\Repositories\Backend\Forum;

use App\Models\Forum\Assignment;
use App\Models\Forum\Problem;
use Illuminate\Support\Facades\DB;
use App\Exceptions\GeneralException;
use App\Repositories\BaseRepository;
use App\Events\Backend\Forum\Problem\ProblemUpdated;
use App\Events\Backend\Forum\Problem\ProblemRestored;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Events\Backend\Forum\Problem\ProblemPermanentlyDeleted;

/**
 * Class ProblemRepository.
 */
class ProblemRepository extends BaseRepository
{
    /**
     * @return string
     */
    public function model()
    {
        return Problem::class;
    }

    /**
     * @return mixed
     */
    public function getCount() : int
    {
        return $this->model
            ->count();
    }

    /**
     * @param int    $paged
     * @param string $orderBy
     * @param string $sort
     *
     * @return mixed
     */
    public function getPaginated($paged = 25, $orderBy = 'created_at', $sort = 'desc') : LengthAwarePaginator
    {
        return $this->model
            ->orderBy($orderBy, $sort)
            ->paginate($paged);
    }

    /**
     * @param Assignment $assignment
     * @param int    $paged
     * @param string $orderBy
     * @param string $sort
     *
     * @return mixed
     */
    public function getPaginatedByAssignment(Assignment $assignment, $paged = 25, $orderBy = 'created_at',
                                             $sort = 'desc') : LengthAwarePaginator
    {
        return $this->model
            ->where('assignment_id', $assignment->id)
            ->orderBy($orderBy, $sort)
            ->paginate($paged);
    }

    /**
     * @param int    $paged
     * @param string $orderBy
     * @param string $sort
     *
     * @return mixed
     */
    public function getDeletedPaginated($paged = 25, $orderBy = 'created_at', $sort = 'desc') : LengthAwarePaginator
    {
        return $this->model
            ->onlyTrashed()
            ->orderBy($orderBy, $sort)
            ->paginate($paged);
    }

    /**
     * @param Problem  $problem
     * @param array $data
     *
     * @return Problem
     * @throws GeneralException
     * @throws \Exception
     * @throws \Throwable
     */
    public function update(Problem $problem, array $data) : Problem
    {
        return DB::transaction(function () use ($problem, $data) {
            if ($problem->update([
                'permalink' => $data['permalink'],
                'content' => $data['content'],
                'difficulty' => $data['difficulty'],
            ])) {
                event(new ProblemUpdated($problem));
                return $problem;
            }

            throw new GeneralException(__('exceptions.backend.access.problems.update_error'));
        });
    }

    /**
     * @param Problem $problem
     *
     * @return Problem
     * @throws GeneralException
     * @throws \Exception
     * @throws \Throwable
     */
    public function forceDelete(Problem $problem) : Problem
    {
        if (is_null($problem->deleted_at)) {
            throw new GeneralException(__('exceptions.backend.access.problems.delete_first'));
        }

        return DB::transaction(function () use ($problem) {
            if ($problem->forceDelete()) {
                event(new ProblemPermanentlyDeleted($problem));
                return $problem;
            }

            throw new GeneralException(__('exceptions.backend.access.problems.delete_error'));
        });
    }

    /**
     * @param Problem $problem
     *
     * @return Problem
     * @throws GeneralException
     */
    public function restore(Problem $problem) : Problem
    {
        if (is_null($problem->deleted_at)) {
            throw new GeneralException(__('exceptions.backend.access.problems.cant_restore'));
        }

        if ($problem->restore()) {
            event(new ProblemRestored($problem));
            return $problem;
        }

        throw new GeneralException(__('exceptions.backend.access.problems.restore_error'));
    }
}
