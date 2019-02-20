<?php

namespace App\Repositories\Backend\Forum;

use App\Models\Forum\Course;
use App\Models\Forum\Assignment;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use App\Exceptions\GeneralException;
use App\Repositories\BaseRepository;
use App\Events\Backend\Forum\Assignment\AssignmentCreated;
use App\Events\Backend\Forum\Assignment\AssignmentUpdated;
use App\Events\Backend\Forum\Assignment\AssignmentRestored;
use App\Events\Backend\Forum\Assignment\AssignmentPermanentlyDeleted;

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
        return $this->model
            ->where('issuer', '=', 0)
            ->count();
    }

    /**
     * @return mixed
     */
    public function getPersonalCount(): int
    {
        return $this->model
            ->where('issuer', '!=', 0)
            ->count();
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
            ->where('due_time', '>=', date("Y-m-d H:i:s"))
            ->orderBy('due_time')
            ->get();
    }

    /**
     * @param $userID
     * @return mixed
     */
    public function getMailAssignments($userID)
    {
        $targetDatetime = \Carbon\Carbon::now()->addDay(2)->startOfDay()->format("Y-m-d H:i:s");
        return $this->model
            ->subscribedByUser($userID)
            ->where('due_time', '>=', date("Y-m-d H:i:s"))
            ->where('due_time', '<=', $targetDatetime)
            ->orderBy('due_time')
            ->get();
    }

    /**
     * @param int    $paged
     * @param string $orderBy
     * @param string $sort
     *
     * @return mixed
     */
    public function getOngoingPaginated($paged = 25, $orderBy = 'created_at', $sort = 'desc') : LengthAwarePaginator
    {
        return $this->model
            ->where('due_time', '>=', date("Y-m-d H:i:s"))
            ->where('issuer', '=', 0)
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
    public function getFinishedPaginated($paged = 25, $orderBy = 'created_at', $sort = 'desc') : LengthAwarePaginator
    {
        return $this->model
            ->where('due_time', '<=', date("Y-m-d H:i:s"))
            ->where('issuer', '=', 0)
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
    public function getPaginated($paged = 25, $orderBy = 'created_at', $sort = 'desc') : LengthAwarePaginator
    {
        return $this->model
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
     * @param Course $course
     * @param int    $paged
     * @param string $orderBy
     * @param string $sort
     *
     * @return mixed
     */
    public function getPaginatedByCourse(Course $course, $paged = 25, $orderBy = 'created_at',
                                           $sort = 'desc') : LengthAwarePaginator
    {
        return $this->model
            ->where('course_id', $course->id)
            ->orderBy($orderBy, $sort)
            ->paginate($paged);
    }

    /**
     * @param array $data
     *
     * @return Assignment
     * @throws GeneralException
     */
    public function create(array $data) : Assignment
    {
        $parser = new \Parsedown();
        return DB::transaction(function () use ($data, $parser) {
            $assignment = parent::create([
                'course_id' => $data['course_id'],
                'name' => $data['name'],
                'content' => $data['content'],
                'content_html' => $parser->text($data['content']),
                'due_time' => $data['due_time'],
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
        $parser = new \Parsedown();
        return DB::transaction(function () use ($assignment, $data, $parser) {
            if ($assignment->update([
                'name' => $data['name'],
                'content' => $data['content'],
                'content_html' => $parser->text($data['content']),
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
    public function forceDelete(Assignment $assignment) : Assignment
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
    public function restore(Assignment $assignment) : Assignment
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
