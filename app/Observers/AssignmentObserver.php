<?php

namespace App\Observers;

use App\Assignment;

class AssignmentObserver
{
    /**
     * Handle the assignment "created" event.
     *
     * @param  \App\Assignment  $assignment
     * @return void
     */
    public function created(Assignment $assignment)
    {
        //
    }

    /**
     * Handle the assignment "updated" event.
     *
     * @param  \App\Assignment  $assignment
     * @return void
     */
    public function updated(Assignment $assignment)
    {
        //
    }

    /**
     * Handle the assignment "deleted" event.
     *
     * @param  \App\Assignment  $assignment
     * @return void
     */
    public function deleted(Assignment $assignment)
    {
        //
    }

    /**
     * Handle the assignment "restored" event.
     *
     * @param  \App\Assignment  $assignment
     * @return void
     */
    public function restored(Assignment $assignment)
    {
        //
    }

    /**
     * Handle the assignment "force deleted" event.
     *
     * @param  \App\Assignment  $assignment
     * @return void
     */
    public function forceDeleted(Assignment $assignment)
    {
        //
    }
}
