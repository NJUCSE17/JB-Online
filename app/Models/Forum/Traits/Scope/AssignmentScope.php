<?php

namespace App\Models\Forum\Traits\Scope;

use function foo\func;

/**
 * Class AssignmentScope.
 */
trait AssignmentScope
{
    public function scopeSubscribedByUser($query, $userID)
    {
        return $query->join('course_enroll_records', function ($join) use ($userID) {
                $join->where('course_enroll_records.user_id', $userID)
                    ->on(function ($join) use ($userID) {
                        $join->where('assignments.issuer', $userID)
                            ->orOn(function ($join) {
                                $join->where('assignments.issuer', 0)
                                    ->on('assignments.course_id', '=', 'course_enroll_records.course_id');
                            });
                    });
            });
    }
}