<?php

namespace App\Observers;

use App\Models\PersonalAssignment;

class PersonalAssignmentObserver
{
    /**
     * Handle the personal assignment "created" event.
     *
     * @param  \App\Models\PersonalAssignment  $personalAssignment
     * @return void
     */
    public function created(PersonalAssignment $personalAssignment)
    {
        //
    }

    /**
     * Handle the personal assignment "updated" event.
     *
     * @param  \App\Models\PersonalAssignment  $personalAssignment
     * @return void
     */
    public function updated(PersonalAssignment $personalAssignment)
    {
        //
    }

    /**
     * Handle the personal assignment "deleted" event.
     *
     * @param  \App\Models\PersonalAssignment  $personalAssignment
     * @return void
     */
    public function deleted(PersonalAssignment $personalAssignment)
    {
        //
    }

    /**
     * Handle the personal assignment "restored" event.
     *
     * @param  \App\Models\PersonalAssignment  $personalAssignment
     * @return void
     */
    public function restored(PersonalAssignment $personalAssignment)
    {
        //
    }

    /**
     * Handle the personal assignment "force deleted" event.
     *
     * @param  \App\Models\PersonalAssignment  $personalAssignment
     * @return void
     */
    public function forceDeleted(PersonalAssignment $personalAssignment)
    {
        //
    }
}
