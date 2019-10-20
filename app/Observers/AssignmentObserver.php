<?php

namespace App\Observers;

use App\Models\Assignment;
use App\Models\AssignmentFinishRecord;
use App\Models\User;
use App\Notifications\AssignmentModifiedEmail;
use Illuminate\Support\Facades\Log;

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
        // only update user if assignment content is updated
        // TODO: update user if DDL is updated.
        if ($assignment->isDirty('content')) {
            $records = AssignmentFinishRecord::query()
                ->where('assignment_id', '=', $assignment->id);
            $userIDs = $records->pluck('user_id')->toArray();
            $records->delete();

            $users = User::query()->whereIn('id', $userIDs)->get();
            foreach ($users as $user) {
                $user->notify(new AssignmentModifiedEmail($user, $assignment));
            }
        }
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
