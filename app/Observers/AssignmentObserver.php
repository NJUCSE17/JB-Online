<?php

namespace App\Observers;

use App\Models\Assignment;
use App\Models\AssignmentFinishRecord;

class AssignmentObserver
{
    /**
     * Handle the assignment "created" event.
     *
     * @param  Assignment  $assignment
     *
     * @return void
     */
    public function created(Assignment $assignment)
    {
        //
    }

    /**
     * Handle the assignment "updated" event.
     *
     * @param  Assignment  $assignment
     *
     * @return void
     */
    public function updated(Assignment $assignment)
    {
        $records = AssignmentFinishRecord::query()
            ->where('assignment_id', '=', $assignment->id);
        $user_ids = $records->pluck('user_id')->toArray();
        $records->delete();
        // TODO: SEND NOTIFICATION TO USERS
    }

    /**
     * Handle the assignment "deleted" event.
     *
     * @param  Assignment  $assignment
     *
     * @return void
     */
    public function deleted(Assignment $assignment)
    {
        //
    }

    /**
     * Handle the assignment "restored" event.
     *
     * @param  Assignment  $assignment
     *
     * @return void
     */
    public function restored(Assignment $assignment)
    {
        //
    }

    /**
     * Handle the assignment "force deleted" event.
     *
     * @param  Assignment  $assignment
     *
     * @return void
     */
    public function forceDeleted(Assignment $assignment)
    {
        //
    }
}
