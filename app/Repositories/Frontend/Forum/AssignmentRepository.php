<?php

namespace App\Repositories\Frontend\Forum;

use App\Events\Backend\Forum\Assignment\AssignmentCreated;
use App\Events\Backend\Forum\Assignment\AssignmentPermanentlyDeleted;
use App\Events\Backend\Forum\Assignment\AssignmentRestored;
use App\Events\Backend\Forum\Assignment\AssignmentUpdated;
use App\Exceptions\GeneralException;
use App\Models\Forum\Assignment;
use App\Repositories\BaseRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

/**
 * Class AssignmentRepository.
 */
class AssignmentRepository extends BaseRepository
{
    /**
     * @return string
     */
    public function model()
    {
        return Assignment::class;
    }

    /**
     * @return mixed
     */
    public function getAllCount(): int
    {
        return $this->model->count();
    }

    /**
     * @return mixed
     */
    public function getOngoingCount(): int
    {
        return $this->model
            ->where('due_time', '>=', date("Y-m-d H:i:s"))
            ->count();
    }

    /**
     * @return Assignment array
     */
    public function getOngoingAssignments()
    {
        return $this->model
            ->where('due_time', '>', date("Y-m-d H:i:s"))
            ->subscribedByUser(Auth::user()->id)
            ->orderBy('due_time')
            ->get(['assignments.*']);
    }

    /**
     * @return Assignment array
     */
    public function APIGetOngoingAssignments()
    {
        $assignments = $this->model
            ->where('due_time', '>', date("Y-m-d H:i:s"))
            ->subscribedByUser(Auth::user()->id)
            ->orderBy('due_time')
            ->get(['id', 'course_id', 'name', 'content', 'due_time', 'issuer']);
        foreach ($assignments as $assignment) {
            $assignment['finished'] = $assignment->is_finished;
        }
        return $assignments;
    }

    /**
     * @return Assignment array
     */
    public function getAssignmentsByTimestamps(int $userID, int $st, int $ed)
    {
        return $this->model
            ->where('due_time', '>=', date("Y-m-d H:i:s", $st))
            ->where('due_time', '<=', date("Y-m-d H:i:s", $ed))
            ->subscribedByUser($userID)
            ->get();
    }

    /**
     * @param $name
     *
     * @return bool
     */
    protected function assignmentExists($course, $name): bool
    {
        return $this->model
                ->where('course', $course)
                ->where('name', strtolower($name))
                ->count() > 0;
    }

    /**
     * @param int
     *
     * @return Assignment
     */
    public function findAssignmentByID($id)
    {
        return $this->model
            ->find($id);
    }

    /**
     * @param integer ID
     *
     * @return mixed
     */
    public function getPersonalAssignmentsPaginated($userID)
    {
        return $this->model
            ->where('issuer', $userID)
            ->where('due_time', '>', date("Y-m-d H:i:s"))
            ->orderBy('due_time', 'asc')
            ->paginate(25);
    }

    /**
     * @param int $paged
     * @param string $orderBy
     * @param string $sort
     *
     * @return mixed
     */
    public function getPersonalFinishedPaginated($userID)
    {
        return $this->model
            ->where('issuer', $userID)
            ->where('due_time', '<=', date("Y-m-d H:i:s"))
            ->orderBy('due_time', 'desc')
            ->paginate(25);
    }

    /**
     * @param int $paged
     * @param string $orderBy
     * @param string $sort
     *
     * @return mixed
     */
    public function getPersonalDeletedPaginated($userID)
    {
        return $this->model
            ->where('issuer', $userID)
            ->onlyTrashed()
            ->orderBy('created_at', 'desc')
            ->paginate(25);
    }

    /**
     * @param array $data
     *
     * @return Assignment
     * @throws GeneralException
     */
    public function create(array $data): Assignment
    {
        return DB::transaction(function () use ($data) {
            $assignment = parent::create([
                'course_id' => 0, // personal
                'name' => $data['name'],
                'content' => $data['content'],
                'due_time' => $data['due_time'],
                'issuer' => \Auth::user()->id,
            ]);

            if ($assignment) {
                event(new AssignmentCreated($assignment));
                return $assignment;
            }

            throw new GeneralException("Error creating a new assignment.");
        });
    }

    /**
     * @param Assignment $assignment
     * @param array $data
     *
     * @return mixed
     * @throws GeneralException
     */
    public function update(Assignment $assignment, array $data)
    {
        return DB::transaction(function () use ($assignment, $data) {
            if ($assignment->update([
                'name' => $data['name'],
                'content' => $data['content'],
                'due_time' => $data['due_time'],
            ])) {
                event(new AssignmentUpdated($assignment));
                return $assignment;
            }

            throw new GeneralException(trans('Error updating an exist assignment.'));
        });
    }

    /**
     * @param Assignment $assignment
     *
     * @return Assignment
     * @throws GeneralException
     * @throws \Exception
     * @throws \Throwable
     */
    public function forceDelete(Assignment $assignment): Assignment
    {
        if (is_null($assignment->deleted_at)) {
            throw new GeneralException(__('exceptions.backend.access.assignments.delete_first'));
        }

        return DB::transaction(function () use ($assignment) {
            if ($assignment->forceDelete()) {
                event(new AssignmentPermanentlyDeleted($assignment));
                return $assignment;
            }

            throw new GeneralException(__('exceptions.backend.access.assignments.delete_error'));
        });
    }

    /**
     * @param Assignment $assignment
     *
     * @return Assignment
     * @throws GeneralException
     */
    public function restore(Assignment $assignment): Assignment
    {
        if (is_null($assignment->deleted_at)) {
            throw new GeneralException(__('exceptions.backend.access.assignments.cant_restore'));
        }

        if ($assignment->restore()) {
            event(new AssignmentRestored($assignment));
            return $assignment;
        }

        throw new GeneralException(__('exceptions.backend.access.assignments.restore_error'));
    }
}
