<?php

namespace App\Models\Traits\PersonalAssignment;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Support\Facades\Auth;

class WithPersonalAssignmentFinishRecordScope implements Scope
{
    /**
     * Apply the scope to the query.
     *
     * @param Builder $builder
     * @param Model $model
     */
    public function apply(Builder $builder, Model $model)
    {
        // Does not check user ID in this scope
        $builder->leftJoin('personal_assignment_finish_records', function (JoinClause $join) {
            $join->on('personal_assignment_finish_records.personal_assignment_id', '=', 'personal_assignments.id');
        })->select([
            'personal_assignments.*',
            'personal_assignment_finish_records.updated_at as finished_at',
            'personal_assignment_finish_records.user_id as record_user_id',
        ]);
    }
}