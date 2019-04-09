<?php

namespace App\Observers;

use App\Models\Assignment;
use App\Models\AssignmentFinishRecord;
use App\Models\CourseEnrollRecord;

class CourseEnrollRecordObserver
{
    /**
     * Handle the course enroll record "created" event.
     *
     * @param  CourseEnrollRecord  $courseEnrollRecord
     *
     * @return void
     */
    public function created(CourseEnrollRecord $courseEnrollRecord)
    {
        //
    }

    /**
     * Handle the course enroll record "updated" event.
     *
     * @param  CourseEnrollRecord  $courseEnrollRecord
     *
     * @return void
     */
    public function updated(CourseEnrollRecord $courseEnrollRecord)
    {
        //
    }

    /**
     * Handle the course enroll record "deleted" event.
     *
     * @param  CourseEnrollRecord  $courseEnrollRecord
     *
     * @return void
     */
    public function deleted(CourseEnrollRecord $courseEnrollRecord)
    {
        $assignment_ids = Assignment::query()
            ->where('course_id', $courseEnrollRecord->course_id)
            ->pluck('id')->toArray();
        AssignmentFinishRecord::query()
            ->whereIn('assignment_id', $assignment_ids)
            ->delete();
    }

    /**
     * Handle the course enroll record "restored" event.
     *
     * @param  CourseEnrollRecord  $courseEnrollRecord
     *
     * @return void
     */
    public function restored(CourseEnrollRecord $courseEnrollRecord)
    {
        //
    }

    /**
     * Handle the course enroll record "force deleted" event.
     *
     * @param  CourseEnrollRecord  $courseEnrollRecord
     *
     * @return void
     */
    public function forceDeleted(CourseEnrollRecord $courseEnrollRecord)
    {
        //
    }
}
