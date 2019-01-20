<?php

namespace App\Repositories\API\Forum;


use App\Models\Forum\Course;
use App\Repositories\BaseRepository;

class CourseController extends BaseRepository
{
    /**
     * @return string
     */
    public function model()
    {
        return Course::class;
    }
}