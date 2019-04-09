<?php

namespace App\Observers;

use App\Models\Course;
use App\Models\CourseEnrollRecord;

class CourseObserver
{
    /**
     * Handle the course "created" event.
     *
     * @param  Course  $course
     *
     * @return void
     */
    public function created(Course $course)
    {
        //
    }

    /**
     * Handle the course "updated" event.
     *
     * @param  Course  $course
     *
     * @return void
     */
    public function updated(Course $course)
    {
        //
    }

    /**
     * Handle the course "deleted" event.
     *
     * @param  Course  $course
     *
     * @return void
     */
    public function deleted(Course $course)
    {
        CourseEnrollRecord::query()
            ->where('course_id', $course->id)
            ->delete();
    }

    /**
     * Handle the course "restored" event.
     *
     * @param  Course  $course
     *
     * @return void
     */
    public function restored(Course $course)
    {
        //
    }

    /**
     * Handle the course "force deleted" event.
     *
     * @param  Course  $course
     *
     * @return void
     */
    public function forceDeleted(Course $course)
    {
        //
    }
}
