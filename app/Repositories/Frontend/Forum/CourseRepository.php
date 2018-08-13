<?php

namespace App\Repositories\Frontend\Forum;

use App\Models\Forum\Course;
use App\Repositories\BaseRepository;

/**
 * Class CourseRepository.
 */
class CourseRepository extends BaseRepository
{
    /**
     * @return string
     */
    public function model()
    {
        return Course::class;
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
            ->where('start_time', '<=', date("Y-m-d H:i:s"))
            ->where('end_time', '>=', date("Y-m-d H:i:s"))
            ->count();
    }

    /**
     * @return mixed
     */
    public function getEndedCount(): int
    {
        return $this->model
            ->where('end_time', '<', date("Y-m-d H:i:s"))
            ->count();
    }

    /**
     * @return Course paginate (5 per page)
     */
    public function getAllCourses()
    {
        return $this->model
            ->where('start_time', '>', date("Y-m-d H:i:s"))
            ->orWhere('end_time', '<', date("Y-m-d H:i:s"))
            ->orderBy('semester', 'DEC')
            ->paginate(5);
    }

    /**
     * @return Course array
     */
    public function getOngoingCourses()
    {
        return $this->model
            ->where('start_time', '<=', date("Y-m-d H:i:s"))
            ->where('end_time', '>=', date("Y-m-d H:i:s"))
            ->get();
    }

    /**
     * @return Course paginate (5 per page)
     */
    public function getEndedCourses()
    {
        $today = date("Y-m-d H:i:s");
        return $this->model
            ->where('end_time', '<', date("Y-m-d H:i:s"))
            ->paginate(5);
    }

    /**
     * @param int $id
     *
     * @return string
     */
    public function getNameLabelByID(int $id) : string
    {
        return $this->model->find($id)->name_label;
    }
}
