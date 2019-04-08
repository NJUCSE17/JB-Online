<?php

namespace App\Observers;

use App\AssignmentFinishRecord;

class AssignmentFinishRecordObserver
{
    /**
     * Handle the assignment finish record "created" event.
     *
     * @param  \App\AssignmentFinishRecord  $assignmentFinishRecord
     * @return void
     */
    public function created(AssignmentFinishRecord $assignmentFinishRecord)
    {
        //
    }

    /**
     * Handle the assignment finish record "updated" event.
     *
     * @param  \App\AssignmentFinishRecord  $assignmentFinishRecord
     * @return void
     */
    public function updated(AssignmentFinishRecord $assignmentFinishRecord)
    {
        //
    }

    /**
     * Handle the assignment finish record "deleted" event.
     *
     * @param  \App\AssignmentFinishRecord  $assignmentFinishRecord
     * @return void
     */
    public function deleted(AssignmentFinishRecord $assignmentFinishRecord)
    {
        //
    }

    /**
     * Handle the assignment finish record "restored" event.
     *
     * @param  \App\AssignmentFinishRecord  $assignmentFinishRecord
     * @return void
     */
    public function restored(AssignmentFinishRecord $assignmentFinishRecord)
    {
        //
    }

    /**
     * Handle the assignment finish record "force deleted" event.
     *
     * @param  \App\AssignmentFinishRecord  $assignmentFinishRecord
     * @return void
     */
    public function forceDeleted(AssignmentFinishRecord $assignmentFinishRecord)
    {
        //
    }
}
