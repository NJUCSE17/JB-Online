<?php

namespace App\Observers;

use App\Models\PersonalAssignment;

class PersonalAssignmentObserver
{
    /**
     * Handle the personal assignment "created" event.
     *
     * @param  PersonalAssignment  $personalAssignment
     *
     * @return void
     */
    public function created(PersonalAssignment $personalAssignment)
    {
        //
    }

    /**
     * Handle the personal assignment "updated" event.
     *
     * @param  PersonalAssignment  $personalAssignment
     *
     * @return void
     */
    public function updated(PersonalAssignment $personalAssignment)
    {
        //
    }

    /**
     * Handle the personal assignment "deleted" event.
     *
     * @param  PersonalAssignment  $personalAssignment
     *
     * @return void
     */
    public function deleted(PersonalAssignment $personalAssignment)
    {
        //
    }

    /**
     * Handle the personal assignment "restored" event.
     *
     * @param  PersonalAssignment  $personalAssignment
     *
     * @return void
     */
    public function restored(PersonalAssignment $personalAssignment)
    {
        //
    }

    /**
     * Handle the personal assignment "force deleted" event.
     *
     * @param  PersonalAssignment  $personalAssignment
     *
     * @return void
     */
    public function forceDeleted(PersonalAssignment $personalAssignment)
    {
        //
    }
}
