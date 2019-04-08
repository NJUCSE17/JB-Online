<?php

namespace App\Observers;

use App\Course;

class CourseObserver
{
    /**
     * Handle the course "created" event.
     *
     * @param  \App\Course  $course
     * @return void
     */
    public function created(Course $course)
    {
        //
    }

    /**
     * Handle the course "updated" event.
     *
     * @param  \App\Course  $course
     * @return void
     */
    public function updated(Course $course)
    {
        //
    }

    /**
     * Handle the course "deleted" event.
     *
     * @param  \App\Course  $course
     * @return void
     */
    public function deleted(Course $course)
    {
        //
    }

    /**
     * Handle the course "restored" event.
     *
     * @param  \App\Course  $course
     * @return void
     */
    public function restored(Course $course)
    {
        //
    }

    /**
     * Handle the course "force deleted" event.
     *
     * @param  \App\Course  $course
     * @return void
     */
    public function forceDeleted(Course $course)
    {
        //
    }
}
