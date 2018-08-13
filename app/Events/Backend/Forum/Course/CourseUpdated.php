<?php

namespace App\Events\Backend\Forum\Course;

use Illuminate\Queue\SerializesModels;

/**
 * Class CourseUpdated.
 */
class CourseUpdated
{
    use SerializesModels;

    /**
     * @var
     */
    public $course;

    /**
     * @param $course
     */
    public function __construct($course)
    {
        $this->course = $course;
    }
}
