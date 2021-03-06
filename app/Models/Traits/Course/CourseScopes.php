<?php

namespace App\Models\Traits\Course;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;

trait CourseScopes
{
    /**
     * Scope of selecting courses that is between a time period.
     *
     * @param  Builder  $builder
     * @param  Carbon   $st
     * @param  Carbon   $ed
     *
     * @return Builder
     */
    public function scopeBetween(Builder $builder, Carbon $st, Carbon $ed)
    {
        return $builder->where('start_time', '<=', $st)
            ->where('end_time', '>=', $ed);
    }
}
