<?php

namespace App\Repositories\Frontend\Forum;

use App\Models\Forum\Assignment;
use App\Repositories\BaseRepository;

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
            ->where('due_time', '>', date("Y-m-d H:i:s"))
            ->orderBy('due_time')
            ->get();
    }

    /**
     * @param $name
     *
     * @return bool
     */
    protected function assignmentExists($course, $name) : bool
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
    public function findAssignmentByID($id) {
        return $this->model
            ->find($id);
    }
}
