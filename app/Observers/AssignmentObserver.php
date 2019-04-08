<?php

namespace App\Observers;

use App\Models\Assignment;

class AssignmentObserver
{
    /**
     * Handle the assignment "created" event.
     *
     * @param  \App\Models\Assignment  $assignment
     * @return void
     */
    public function created(Assignment $assignment)
    {
        //
    }

    /**
     * Handle the assignment "updated" event.
     *
     * @param  \App\Models\Assignment  $assignment
     * @return void
     */
    public function updated(Assignment $assignment)
    {
        //
    }

    /**
     * Handle the assignment "deleted" event.
     *
     * @param  \App\Models\Assignment  $assignment
     * @return void
     */
    public function deleted(Assignment $assignment)
    {
        //
    }

    /**
     * Handle the assignment "restored" event.
     *
     * @param  \App\Models\Assignment  $assignment
     * @return void
     */
    public function restored(Assignment $assignment)
    {
        //
    }

    /**
     * Handle the assignment "force deleted" event.
     *
     * @param  \App\Models\Assignment  $assignment
     * @return void
     */
    public function forceDeleted(Assignment $assignment)
    {
        //
    }
}
