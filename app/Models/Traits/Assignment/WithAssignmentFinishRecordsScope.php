<?php

namespace App\Models\Traits\Assignment;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Support\Facades\Auth;

class WithAssignmentFinishRecordsScope implements Scope
{
    /**
     * Apply the scope to the query.
     *
     * @param Builder $builder
     * @param Model $model
     */
    public function apply(Builder $builder, Model $model)
    {
        $builder->leftJoin('assignment_finish_records', function ($join) {
            $join->on('assignment_finish_records.assignment_id', '=', 'assignments.id');
            $join->where('assignment_finish_records.user_id', '=', Auth::id());
        })->select(['assignments.*', 'assignment_finish_records.updated_at as finished_at']);
    }
}