<?php

namespace App\Models\Forum\Traits\Scope;

/**
 * Class AssignmentScope.
 */
trait AssignmentScope
{
    public function scopeSubscribedByUser($query, $userID)
    {
        $query->leftJoin('course_enroll_records', function ($join) use ($userID) {
               $join->where('course_enroll_records.user_id', '=', $userID)
                   ->on('course_enroll_records.course_id', '=', 'assignments.course_id');
            })
            ->where('assignments.issuer', $userID)
            ->orWhere(function ($query) use ($userID) {
                $query->where('assignments.issuer', 0)
                    ->whereNotNull('course_enroll_records.id');
            });
    }
}