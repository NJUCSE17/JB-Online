<?php


namespace App\Models\Traits\Assignment;


use App\Models\AssignmentFinishRecord;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

trait AssignmentAttributes
{
    /**
     * Get whether the assignment is marked ongoing.
     *
     * @param  User  $user
     *
     * @return mixed
     */
    public function isOngoing(User $user)
    {
        $record = AssignmentFinishRecord::query()
            ->where('user_id', $user->id)
            ->where('assignment_id', $this->id)
            ->first();

        return $record ? $record->is_ongoing : null;
    }

    /**
     * Get the timestamp of finished info.
     *
     * @param  User  $user
     *
     * @return mixed
     */
    public function finishedAt(User $user)
    {
        $record = AssignmentFinishRecord::query()
            ->where('user_id', $user->id)
            ->where('assignment_id', $this->id)
            ->first();

        return ($record && !$record->is_ongoing) ? $record->updated_at->setTimezone($user->timezone) : null;
    }

    /**
     * Get rated info of an assignment.
     *
     * @return array
     */
    public function ratedInfo()
    {
        return [
            'rated' => $this->rated(),
            'stats' => $this->stats(),
        ];
    }

    /**
     * Get rated string of an assignment.
     *
     * @return string
     */
    public function rated()
    {
        $user = Auth::user();

        return $this->isLikedBy($user) ? "like"
            : ($this->isDislikedBy($user) ? "dislike" : "null");
    }

    /**
     * Get rated stats of an assignment.
     *
     * @return array
     */
    public function stats()
    {
        return [
            'like'    => $this->likesCount,
            'dislike' => $this->dislikesCount,
        ];
    }
}
