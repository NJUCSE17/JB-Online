<?php


namespace App\Models\Traits\Assignment;


use Illuminate\Support\Facades\Auth;

trait AssignmentAttributes
{
    /**
     * Get rated info of an assignment.
     *
     * @return array
     */
    public function ratedInfo() {
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
    public function rated() {
        $user = Auth::user();
        return $this->isLikedBy($user) ? "like"
            : ($this->isDislikedBy($user) ? "dislike" : "null");
    }

    /**
     * Get rated stats of an assignment.
     *
     * @return array
     */
    public function stats() {
        return [
            'like'    => $this->likesCount,
            'dislike' => $this->dislikesCount,
        ];
    }
}