<?php

namespace App\Observers;

use App\Models\CourseEnrollRecord;

class CourseEnrollRecordObserver
{
    /**
     * Handle the course enroll record "created" event.
     *
     * @param  \App\Models\CourseEnrollRecord  $courseEnrollRecord
     * @return void
     */
    public function created(CourseEnrollRecord $courseEnrollRecord)
    {
        //
    }

    /**
     * Handle the course enroll record "updated" event.
     *
     * @param  \App\Models\CourseEnrollRecord  $courseEnrollRecord
     * @return void
     */
    public function updated(CourseEnrollRecord $courseEnrollRecord)
    {
        //
    }

    /**
     * Handle the course enroll record "deleted" event.
     *
     * @param  \App\Models\CourseEnrollRecord  $courseEnrollRecord
     * @return void
     */
    public function deleted(CourseEnrollRecord $courseEnrollRecord)
    {
        //
    }

    /**
     * Handle the course enroll record "restored" event.
     *
     * @param  \App\Models\CourseEnrollRecord  $courseEnrollRecord
     * @return void
     */
    public function restored(CourseEnrollRecord $courseEnrollRecord)
    {
        //
    }

    /**
     * Handle the course enroll record "force deleted" event.
     *
     * @param  \App\Models\CourseEnrollRecord  $courseEnrollRecord
     * @return void
     */
    public function forceDeleted(CourseEnrollRecord $courseEnrollRecord)
    {
        //
    }
}
