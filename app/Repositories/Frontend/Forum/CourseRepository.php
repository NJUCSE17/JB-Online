<?php

namespace App\Repositories\Frontend\Forum;

use App\Models\Forum\Course;
use App\Repositories\BaseRepository;
use Illuminate\Support\Facades\Auth;

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
     * @return Course paginate (25 per page)
     */
    public function getAllCourses()
    {
        return $this->model
            ->orderBy('semester', 'DEC')
            ->paginate(25);
    }

    /**
     * @return Course array
     */
    public function getOngoingCourses()
    {
        return $this->model
            ->where('start_time', '<=', date("Y-m-d H:i:s"))
            ->where('end_time', '>=', date("Y-m-d H:i:s"))
            ->subscribedByUser(Auth::user()->id)
            ->get(['courses.*']);
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
